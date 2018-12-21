<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Products;
use App\Suppliers;
use DB;
use Khill\Lavacharts\Lavacharts;
use DateTime;

session_start();

class PagesController extends Controller
{
    public function index(){
        $title = 'Welcome to 360 Dashboard!';
        return view('pages.index')->with('title', $title);
    }

    public function about(){
        $title = 'About us';
        return view('pages.about')->with('title', $title);
    }


    public function overview(){

        return view('pages.overview');
    }


    public function getDetails(Request $request, $id)
    {

      $user_data = DB::table('customers')
      ->where('CustomerID', 'LIKE', '%' . $id . '%')
      ->get();

      $user_entries = DB::select("select COUNT(CustomerID) as entries from invoices where CustomerID='$id'");

      $user_purchases = DB::select("select ProductDescription, Quantity, temp.cid from `lines` JOIN (Select CustomerID as cid, InvoiceNo as id from `invoices` where CustomerID='$id') as temp ON temp.id=`lines`.`InvoiceNo`");
      return response()->json(array($user_data,$user_entries,$user_purchases));
    }


    public function getSupDetails(Request $request, $id)
    {

      $user_data = DB::table('suppliers')
      ->where('SupplierID', 'LIKE', '%' . $id . '%')
      ->get();


      $user_entries = DB::select("select COUNT(Entidade) as entries from cabec_compras where Entidade='$id'");

      $user_sells = DB::select("select Descricao, Quantidade, temp.sid from `linhas_compras` JOIN (Select Entidade as sid, Id as id from `cabec_compras` where Entidade='$id') as temp ON temp.id=`linhas_compras`.`IdCabecCompras`");
      return response()->json(array($user_data,$user_entries,$user_sells));
    }


    public function getProductDetails(Request $request, $name){


        $product_data = DB::select("Select * from products
        JOIN (SELECT ProductDescription as name, SUM(CreditAmount) as totalPrice
        FROM `lines` GROUP BY ProductDescription) as temp
        ON temp.name=products.ProductDescription
         WHERE products.ProductDescription ='$name'");


        return response()->json($product_data);
    }


    public function getProductSupDetails(Request $request, $name){


        $product_data = DB::select("Select * from products
        JOIN (SELECT Descricao as name, SUM(TotalIliquido) as totalPrice
        FROM `linhas_compras` GROUP BY Descricao) as temp
        ON temp.name=products.ProductDescription
         WHERE products.ProductDescription ='$name'");


        return response()->json($product_data);
    }




    public function getInfoProduct(Request $request, $name){
        $product_info = DB::select("select * from products where ProductDescription='$name'");
        $product_revenue = DB::select("select ProductDescription, SUM(CreditAmount) as revenue from `lines` where ProductDescription='$name' GROUP BY ProductDescription");
        $product_topBuyers = DB::select("select ProductDescription, SUM(Quantity) as totalQuantity, invoices.CustomerID as cid from `lines` JOIN invoices ON invoices.InvoiceNo=`lines`.`InvoiceNo` where ProductDescription='$name' GROUP BY CustomerID");
        $product_last_purchase = DB::select("select ProductDescription, InvoiceDate from `lines` JOIN invoices ON `lines`.InvoiceNo=invoices.InvoiceNo where ProductDescription='$name' ORDER BY InvoiceDate DESC");
        return response()->json(array($product_info,$product_revenue,$product_topBuyers,$product_last_purchase));

    }

    public function sales(){
        if(strcmp($_SESSION["saftUploaded"], "false")==0)
            return redirect('/saft')->with('error', 'Please upload SAFT and turn on VM');
        $customers = DB::select(
            'select *
            from customers
            INNER JOIN
            (select CustomerID as cid, SUM(DocumentTotals_GrossTotal) as total
            from invoices
            GROUP BY cid) as temp
            ON temp.cid = customers.CustomerID
            ORDER BY temp.total DESC');

        $monthSales = DB::select(
            'select distinct MONTH(invoiceDate) as month, SUM(DocumentTotals_GrossTotal) as total
             from invoices
             GROUP BY MONTH(invoices.invoiceDate)'
        );

        $year = DB::select('select distinct YEAR(invoiceDate) as year from invoices');
        $sales = \Lava::DataTable();
        $sales->addDateColumn('Month')
              ->addNumberColumn('Sales');

        $actifs = DB::select('select CompanyName, COUNT(invoices.CustomerID) as counter from `invoices` JOIN customers ON customers.CustomerID =invoices.CustomerID GROUP BY invoices.CustomerID ORDER BY counter DESC');

        foreach($monthSales as $monthsale){
            $sales->addRow([$year[0]->year.'-'.$monthsale->month.'-1',$monthsale->total]);
        }
        $Chart = \Lava::LineChart('Sales', $sales,[
            'title' => 'Sales by current SAFT'
        ]);

        $invoice = DB::select('select COUNT(CustomerID) as counter, MONTH(invoices.InvoiceDate) as month FROM invoices GROUP BY month');
        $invoices = \Lava::DataTable();
        $invoices->addStringColumn('Month');
        $invoices->addNumberColumn('number of invoices per month');
        foreach($invoice as $singleInvoice){
            $dt = DateTime::createFromFormat('!m', $singleInvoice->month);

            $invoices->addRow(
                [$dt->format('F'),$singleInvoice->counter]
            );
        }

        $pieChart = \Lava::PieChart('Invoices', $invoices,[
            'width'=>400,
            'pieSliceText' => 'value'
        ]);

        $filter  = \Lava::NumberRangeFilter(1, [
            'ui' => [
                'labelStacking' => 'vertical'
            ]
        ]);


        $control = \Lava::ControlWrapper($filter,'control');
        $chartTwo = \Lava::ChartWrapper($pieChart,'chart');
        \Lava::Dashboard('Invoices')->bind($control,$chartTwo);





        $products = DB::select('Select * from products
         JOIN (SELECT ProductDescription as name, SUM(CreditAmount) as totalPrice
         FROM `lines` GROUP BY ProductDescription) as temp
         ON temp.name=products.ProductDescription
          ORDER BY temp.totalPrice DESC');
        return view('pages.sales')->with(compact('customers','products','sales','actifs','invoices'));
    }


    public function suppliers(){

    if(strcmp($_SESSION["saftUploaded"], "false")==0)
        return redirect('/saft')->with('error', 'Please upload SAFT and turn on VM');


    $suppliers = DB::select(
        'select *
        from suppliers
        INNER JOIN
        (select Entidade as sid, SUM(TotalMerc) as total
        from cabec_compras
        GROUP BY sid) as temp
        ON temp.sid = suppliers.SupplierID
        ORDER BY temp.total DESC');

    $monthSales = DB::select(
        'select distinct MONTH(DataDoc) as month, SUM(TotalMerc) as total
         from cabec_compras
         GROUP BY MONTH(cabec_compras.DataDoc)'
    );

    $year = DB::select('select distinct YEAR(DataDoc) as year from cabec_compras');
    $buys = \Lava::DataTable();
    $buys->addDateColumn('Month')
          ->addNumberColumn('Buys');


    foreach($monthSales as $monthsale){
        $buys->addRow([$year[0]->year.'-'.$monthsale->month.'-1',$monthsale->total]);
    }
    $Chart = \Lava::LineChart('Buys', $buys,[
        'title' => 'Supplies'
    ]);



      $products = DB::select('Select * from products
       JOIN (SELECT Descricao as name, SUM(TotalIliquido) as totalPrice
       FROM `linhas_compras` GROUP BY Descricao) as temp
       ON temp.name=products.ProductDescription
        ORDER BY temp.totalPrice DESC');



        return view('pages.suppliers')->with(compact('suppliers','products','buys'));
    }


    public function inventory(){
        if(strcmp($_SESSION["saftUploaded"], "false")==0)
            return redirect('/saft')->with('error', 'Please upload SAFT and turn on VM');

        $products_stock = DB::select('select ProductDescription, ProductStkCurrent from products order by ProductStkCurrent DESC');
        $products_sales = DB::select('select ProductDescription, SUM(Quantity)as totals from `lines` GROUP BY ProductDescription ORDER BY totals DESC');



        $inventoryTotals = DB::select('SELECT ProductDescription, ProductStkCurrent, ProductUnitaryPrice,  ProductStkCurrent*ProductUnitaryPrice as bruteValue FROM `products`');
        $inventory = \Lava::DataTable();
        $inventory->addStringColumn('Product');
        $inventory->addNumberColumn('Gross Value in Stock');
        foreach($inventoryTotals as $product_inventory_stock){
            $inventory->addRow(
                [$product_inventory_stock->ProductDescription,$product_inventory_stock->bruteValue]
            );
        }

        $pieChart = \Lava::PieChart('Gross Value', $inventory,[
            'width'=>400,
            'pieSliceText' => 'value'
        ]);

        $filter  = \Lava::NumberRangeFilter(1, [
            'ui' => [
                'labelStacking' => 'vertical'
            ]
        ]);


        $control = \Lava::ControlWrapper($filter,'control');
        $chartTwo = \Lava::ChartWrapper($pieChart,'chart');
        \Lava::Dashboard('Gross Value')->bind($control,$chartTwo);



        return view('pages.inventory')->with(compact('products_sales','products_stock','inventory'));
    }

    public function financial(){
        if(strcmp($_SESSION["saftUploaded"], "false")==0)
            return redirect('/saft')->with('error', 'Please upload SAFT and turn on VM');

      $monthSales = DB::select(
          'select distinct MONTH(invoiceDate) as month, SUM(DocumentTotals_GrossTotal) as total
           from invoices
           GROUP BY MONTH(invoices.invoiceDate)'
      );

      $monthShops = DB::select(
          'select distinct MONTH(DataDoc) as month, SUM(TotalMerc) as total
           from cabec_compras
           WHERE YEAR(DataDoc) = 2018 AND MONTH(DataDoc) < 5
           GROUP BY MONTH(cabec_compras.DataDoc)'
      );

      $months = DB::select('select distinct MONTH(invoiceDate) as month from invoices');

      $finances = \Lava::DataTable();

      $finances->addDateColumn('Month')
               ->addNumberColumn('Income')
               ->addNumberColumn('Expenses')
               ->setDateTimeFormat('M');

      $index = 0;
      $index2 = 0;

      foreach($monthSales as $monthSale) {
        $dt = DateTime::createFromFormat('!m', $monthSale->month);

        if ($index2 < count($monthShops)) {
          if ($monthSale->month == $monthShops[$index2]->month) {
            $finances->addRow([$dt->format('F'), $monthSale->total, $monthShops[$index2]->total]); //$months[$index]->month
            $index2++;
          }
          else {
            $finances->addRow([$dt->format('F'), $monthSale->total, 0]); //$months[$index]->month
          }
        } else {
          $finances->addRow([$dt->format('F'), $monthSale->total, 0]); //$months[$index]->month
        }

        $index++;
      }

      \Lava::ColumnChart('Finances', $finances, [
          'title' => 'Company Performance',
          'titleTextStyle' => [
              'color'    => '#eb6b2c',
              'fontSize' => 14
          ]
      ]);

      //Cash Querys

      $debitCash = DB::select(
        'SELECT SUM(ClosingDebitBalance) as deSum FROM `accounts` WHERE AccountID LIKE "1%"'
      );

      $creditCash = DB::select(
        'SELECT SUM(ClosingCreditBalance) as creSum FROM `accounts` WHERE AccountID LIKE "1%"'
      );

      $cash = $debitCash[0]->deSum - $creditCash[0]->creSum;

      //Total TotalAssets
      $accounts2deb = DB::select(
        'SELECT SUM(ClosingDebitBalance) as deSum FROM `accounts` WHERE AccountID LIKE "2%"'
      );

      $accounts2cred = DB::select(
        'SELECT SUM(ClosingCreditBalance) as creSum FROM `accounts` WHERE AccountID LIKE "2%"'
      );

      $accounts2 = $accounts2deb[0]->deSum - $accounts2cred[0]->creSum;

      $accounts3deb = DB::select(
        'SELECT SUM(ClosingDebitBalance) as deSum FROM `accounts` WHERE AccountID LIKE "3%"'
      );

      $accounts3cred = DB::select(
        'SELECT SUM(ClosingCreditBalance) as creSum FROM `accounts` WHERE AccountID LIKE "3%"'
      );

      $total_assets = $cash + $accounts2 + $accounts3deb[0]->deSum - $accounts3cred[0]->creSum;

      //Liabilities

      $liabilities22deb = DB::select(
        'SELECT SUM(ClosingDebitBalance) as deSum FROM `accounts` WHERE AccountID LIKE "22%"'
      );

      $liabilities22cre = DB::select(
        'SELECT SUM(ClosingCreditBalance) as creSum FROM `accounts` WHERE AccountID LIKE "22%"'
      );

      $liabilities1 = $liabilities22deb[0]->deSum - $liabilities22cre[0]->creSum;

      $liabilities23deb = DB::select(
        'SELECT SUM(ClosingDebitBalance) as deSum FROM `accounts` WHERE AccountID LIKE "23%"'
      );

      $liabilities23cre = DB::select(
        'SELECT SUM(ClosingCreditBalance) as creSum FROM `accounts` WHERE AccountID LIKE "23%"'
      );

      $liabilities2 = $liabilities23deb[0]->deSum - $liabilities23cre[0]->creSum;

      $liabilities24deb = DB::select(
        'SELECT SUM(ClosingDebitBalance) as deSum FROM `accounts` WHERE AccountID LIKE "24%"'
      );

      $liabilities24cre = DB::select(
        'SELECT SUM(ClosingCreditBalance) as creSum FROM `accounts` WHERE AccountID LIKE "24%"'
      );

      $liabilities3 = $liabilities24deb[0]->deSum - $liabilities24cre[0]->creSum;

      $liabilities25deb = DB::select(
        'SELECT SUM(ClosingDebitBalance) as deSum FROM `accounts` WHERE AccountID LIKE "25%"'
      );

      $liabilities25cre = DB::select(
        'SELECT SUM(ClosingCreditBalance) as creSum FROM `accounts` WHERE AccountID LIKE "25%"'
      );

      $total_liabilities = abs($liabilities1 + $liabilities2 + $liabilities3 + $liabilities25deb[0]->deSum - $liabilities25cre[0]->creSum);

      return view('pages.financial')->with(compact('finances','cash','total_assets','total_liabilities'));
    }
}
