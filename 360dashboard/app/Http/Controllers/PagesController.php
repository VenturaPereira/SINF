<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Products;
use App\Suppliers;
use DB;
use Khill\Lavacharts\Lavacharts;
use DateTime;
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


    public function getProductDetails(Request $request, $name){


        $product_data = DB::select("Select * from products
        JOIN (SELECT ProductDescription as name, SUM(CreditAmount) as totalPrice
        FROM `lines` GROUP BY ProductDescription) as temp
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

        $invoice = DB::select('select COUNT(CustomerID) as counter, CustomerID, MONTH(invoices.InvoiceDate) as month FROM invoices GROUP BY CustomerID');
        $invoices = \Lava::DataTable();
        $invoices->addStringColumn('Month');
        $invoices->addNumberColumn('number of invoices by client and month');
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


      $suppliers = Suppliers::all();

    /*  $suppliers = DB::select(
          'select *
          from suppliers
          INNER JOIN
          (select CustomerID as cid, SUM(DocumentTotals_GrossTotal) as total
          from invoices
          GROUP BY cid) as temp
          ON temp.cid = suppliers.SupplierID
          ORDER BY temp.total DESC');

      $monthSales = DB::select(
          'select distinct MONTH(invoiceDate) as month, SUM(DocumentTotals_GrossTotal) as total
           from invoices
           GROUP BY MONTH(invoices.invoiceDate)'
      );

      $year = DB::select('select distinct YEAR(invoiceDate) as year from invoices');

      $supplies = \Lava::DataTable();
      $supplies->addDateColumn('Month')
            ->addNumberColumn('Supplies');


      foreach($monthSales as $monthsale){
          $supplies->addRow([$year[0]->year.'-'.$monthsale->month.'-1',$monthsale->total]);
      }
      $Chart = \Lava::LineChart('Sales', $supplies,[
          'title' => 'Supplies'
      ]);*/

    /*  $total_gross = \Lava::DataTable();
      $total_gross->addStringColumn('total_gross')
                  ->addNumberColumn('Value');



      foreach($suppliers as $supplier){
        $total_gross->addRow([$supplier->CompanyName, $supplier->TotalDeb]);
    }


      $Chart = \Lava::PieChart('total_gross', $total_gross,[
          'title' => 'Total gross/supplier'
      ]);*/

      $products = Products::all();





        return view('pages.suppliers')->with(compact('suppliers','products'));
    }


    public function inventory(){

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
               ->setDateTimeFormat('Y');

      $index = 0;
      $index2 = 0;

      foreach($monthSales as $monthSale) {
        if ($monthSale->month == $monthShops[$index2]->month) {
          $finances->addRow(['2004', $monthSale->total, $monthShops[$index2]->total]); //$months[$index]->month
          $index2++;
        }
        else {
          $finances->addRow(['2004', $monthSale->total, 0]); //$months[$index]->month
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

      return view('pages.financial')->with(compact('finances'));
    }
}



