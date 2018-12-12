<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Products;
use App\Suppliers;
use DB;
use Khill\Lavacharts\Lavacharts;

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
      
      return response()->json($user_data);
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


        foreach($monthSales as $monthsale){
            $sales->addRow([$year[0]->year.'-'.$monthsale->month.'-1',$monthsale->total]);
        }
        $Chart = \Lava::LineChart('Sales', $sales,[
            'title' => 'Sales by current SAFT'
        ]);
        $products = Products::all();
        return view('pages.sales')->with(compact('customers','products','sales'));
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

        $products = Products::all();
        $products_stock = $products->sortBy('ProductQuantity', SORT_REGULAR, true);
        $products_sales = $products->sortBy('ProductSales', SORT_REGULAR, true);

        return view('pages.inventory')->with(compact('products_sales','products_stock'));
    }

    public function financial(){

        return view('pages.financial');
    }
}
