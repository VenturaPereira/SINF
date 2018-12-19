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

class OverviewController extends Controller
{
    public function getLaraChart()
    {
        $newCountry = new CountryUser;
        $newCountry->name = 'India';
        $newCountry->total_users = 1000;
        $newCountry->save();

        $newCountry = new CountryUser;
        $newCountry->name = 'Portugal';
        $newCountry->total_users = 200;
        $newCountry->save();

        
    	$lava = new Lavacharts; // See note below for Laravel

		$popularity = $lava->DataTable();
		$data = CountryUser::select("name as 0","total_users as 1")->get()->toArray();

		$popularity->addStringColumn('Country')->addNumberColumn('Popularity')->addRows($data);

        $lava->GeoChart('Popularity', $popularity);
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


        $debit = GeneralLedgerEntries::all('TotalDebit')->first();
        $credit = GeneralLedgerEntries::all('TotalCredit')->first();
        $clients = Customer::count();
        $suppliers = Suppliers::count();

        $infoOverview = array($lava, $credit->TotalCredit, $debit->TotalDebit, $clients, $suppliers);

        return view('pages.overview')->with('infoOverview',$infoOverview);
    }

    public function getYearProfit(Request $request){

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

}
