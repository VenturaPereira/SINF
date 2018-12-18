<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use App\CountryUser;
use App\Invoices;
use App\CabecCompras;
use App\Customer;
use App\Suppliers;
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
        $posts = DB:select('SELECT * FROM posts');

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
}
