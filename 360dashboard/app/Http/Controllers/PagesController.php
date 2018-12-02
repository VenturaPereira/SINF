<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Products;
use App\Suppliers;

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

      $suppliers = Suppliers::all();
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
