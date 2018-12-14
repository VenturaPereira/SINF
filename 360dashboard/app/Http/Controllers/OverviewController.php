<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use App\CountryUser;

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


		$popularity->addStringColumn('Country')
		           ->addNumberColumn('Popularity')
		           ->addRows($data);


		$lava->GeoChart('Popularity', $popularity);


        return view('pages.overview',compact('lava'));
    }
}
