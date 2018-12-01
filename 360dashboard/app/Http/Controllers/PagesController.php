<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Products;

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


    public function sales(){

        $customers = Customer::all();
        $products = Products::all();
        return view('pages.sales')->with(compact('customers','products'));
    }


    public function suppliers(){

        return view('pages.suppliers');
    }


    public function inventory(){

        return view('pages.inventory');
    }

    public function financial(){

        return view('pages.financial');
    }
}
