<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use App\CountryUser;
use App\Invoices;
use App\CabecCompras;
use App\Customer;
use App\Suppliers;
use App\GeneralLedgerEntries;
use DB;

session_start();

class OverviewController extends Controller
{
    public function getLaraChart()
    {

        if(strcmp($_SESSION["saftUploaded"], "false")==0)
            return redirect('/saft')->with('error', 'Please upload SAFT and turn on VM');

        $COUNTRY = array(
            "AO" => "Angola",
            "ES" => "Spain",
            "PT" => "Portugal",
            "GB" => "United Kingdom",
            "Desconhecido" => "Antarctica"
          );

        $customers = DB::select('SELECT CustomerID,DocumentTotals_GrossTotal FROM invoices');
        $json = json_encode($customers);
        $customers = json_decode($json,TRUE);
 

        foreach($customers as $customer){
            $customerID =  $customer['CustomerID'];
            $customerGrossTotal =  $customer['DocumentTotals_GrossTotal'];
            $customerCountry = DB::select("SELECT BillingAddress_Country FROM customers where CustomerID = '$customerID' ");

            $json = json_encode($customerCountry);
            $customerCountry = json_decode($json,TRUE);

            $country = $COUNTRY[$customerCountry[0]["BillingAddress_Country"]];
            $existsCountry = DB::select("SELECT name FROM country_users where name = '$country'");

            if(!empty($existsCountry)){
                $row = CountryUser::where('name', $country)->get();
                $row_newGrossTotal = $row[0]["total_sales"] + $customerGrossTotal;
                DB::select("UPDATE country_users SET total_sales = '$row_newGrossTotal' where name = '$country'");
            }
            else{
                $newCountry = new CountryUser;
                $countryAbrev = $customerCountry[0]["BillingAddress_Country"];
                $newCountry->name = $COUNTRY[$countryAbrev];
                $newCountry->total_sales = $newCountry->total_sales + $customerGrossTotal;
                $newCountry->save();
            }
        }

        
    	$lava = new Lavacharts; // See note below for Laravel

		$sales = $lava->DataTable();
		$data = CountryUser::select("name as 0","total_sales as 1")->get()->toArray();

		$sales->addStringColumn('Country')->addNumberColumn('Sales(€)')->addRows($data);

        $lava->GeoChart('Sales', $sales);

    /*
        //tudo
        $posts = Post::all();

        //especificar
        return Post::where('title', 'Post Two')->get();

        //usar DB
        $posts = DB::select('SELECT * FROM posts');

        //pagination
        $posts = Post::orderBy('title', 'desc')->paginate(1);
        colocar     {{ $posts->links() }}  depois do @endforeach em index.blade
    */

        $cash = Invoices::all()->sum('DocumentTotals_GrossTotal');
        $expenditures = CabecCompras::all()->sum('TotalIva');
        $clients = Customer::count();
        $suppliers = Suppliers::count();

        $infoOverview = array($lava, $cash, $expenditures, $clients, $suppliers);

        return view('pages.overview')->with('infoOverview',$infoOverview);
    }

    public function getYearSales(Request $request){

        if(strcmp($_SESSION["saftUploaded"], "false")==0)
            return redirect('/saft')->with('error', 'Please upload SAFT and turn on VM');

        $data = [];

        $totalBuyCash = DB::select(" SELECT sum(TotalIva) FROM cabec_compras WHERE year(DataDoc) = 2018  ");
        $totalSalesCash = DB::select(" SELECT sum(DocumentTotals_GrossTotal) FROM invoices WHERE year(InvoiceDate) = 2018  ");

        $json_totalBuyCash = json_encode($totalBuyCash);
        $json_totalSalesCash = json_encode($totalSalesCash);

        $totalBuyCash = json_decode($json_totalBuyCash,TRUE);
        $totalSalesCash = json_decode($json_totalSalesCash,TRUE);


        $total = GeneralLedgerEntries::all('TotalCredit')->first();
        $total = $total->TotalCredit - abs($totalSalesCash[0]['sum(DocumentTotals_GrossTotal)']);

        for ($month = 1; $month <= 12; $month++) {

            $BuyMonth = DB::select(" SELECT sum(TotalIva) FROM cabec_compras WHERE year(DataDoc) = 2018 and month(DataDoc) = '$month' ");
            $SalesMonth = DB::select(" SELECT sum(DocumentTotals_GrossTotal) FROM invoices WHERE year(InvoiceDate) = 2018 and month(InvoiceDate) = '$month' ");

            $json_BuyMonth = json_encode($BuyMonth);
            $json_SalesMonth = json_encode($SalesMonth);
    
            $BuyMonth = json_decode($json_BuyMonth,TRUE);
            $SalesMonth = json_decode($json_SalesMonth,TRUE);
         
            $total = $total + abs($SalesMonth[0]['sum(DocumentTotals_GrossTotal)']);

            array_push($data, $total);
        }

        return response()->json(['labels' => ["Jan", "Fev", "Mar", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],'data' => $data], 200);
    }

    public function getYearSupplies(Request $request){

        if(strcmp($_SESSION["saftUploaded"], "false")==0)
            return redirect('/saft')->with('error', 'Please upload SAFT and turn on VM');

        $data = [];

        $totalBuyCash = DB::select(" SELECT sum(TotalIva) FROM cabec_compras WHERE year(DataDoc) = 2018  ");
        $totalSalesCash = DB::select(" SELECT sum(DocumentTotals_GrossTotal) FROM invoices WHERE year(InvoiceDate) = 2018  ");

        $json_totalBuyCash = json_encode($totalBuyCash);
        $json_totalSalesCash = json_encode($totalSalesCash);

        $totalBuyCash = json_decode($json_totalBuyCash,TRUE);
        $totalSalesCash = json_decode($json_totalSalesCash,TRUE);


        $total = GeneralLedgerEntries::all('TotalDebit')->first();
        $total = $total->TotalDebit - abs($totalBuyCash[0]['sum(TotalIva)']);

        for ($month = 1; $month <= 12; $month++) {

            $BuyMonth = DB::select(" SELECT sum(TotalIva) FROM cabec_compras WHERE year(DataDoc) = 2018 and month(DataDoc) = '$month' ");
            $SalesMonth = DB::select(" SELECT sum(DocumentTotals_GrossTotal) FROM invoices WHERE year(InvoiceDate) = 2018 and month(InvoiceDate) = '$month' ");

            $json_BuyMonth = json_encode($BuyMonth);
            $json_SalesMonth = json_encode($SalesMonth);
    
            $BuyMonth = json_decode($json_BuyMonth,TRUE);
            $SalesMonth = json_decode($json_SalesMonth,TRUE);
         
            $total = $total + abs($BuyMonth[0]['sum(TotalIva)']);

            array_push($data, $total);
        }

        return response()->json(['labels' => ["Jan", "Fev", "Mar", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],'data' => $data], 200);
    }

}
