<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Products;
use App\Suppliers;
use App\Invoices;
use App\CabecCompras;

class AjaxController extends Controller
{
    public function graphsData(Request $request){
    $dataPoints = array(
    	array("y" => 25, "label" => "January"),
    	array("y" => 15, "label" => "February"),
    	array("y" => 25, "label" => "March"),
    	array("y" => 5, "label" => "April"),
    	array("y" => 10, "label" => "May"),
    	array("y" => 0, "label" => "June"),
    	array("y" => 20, "label" => "July"),
      array("y" => 30, "label" => "August"),
      array("y" => 22, "label" => "September"),
      array("y" => 21, "label" => "October"),
      array("y" => 18, "label" => "November"),
      array("y" => 6, "label" => "December")
    );


    $dataPoints = json_encode($dataPoints,JSON_NUMERIC_CHECK);
    return response()->json($dataPoints);
  }

     public function roundGraphsStock(Request $request){

       $products = Products::all();
       $products_price_stock = $products->sortBy('ProductQuantity*ProductUnitaryPrice', SORT_REGULAR, true);
       $products_price_stock = $products_price_stock->take(10);
       $dataPoints = array();

       foreach($products_price_stock as $product){
         array_push($dataPoints,array("y" => ($product->ProductQuantity * $product->ProductUnitaryPrice),
         "name" => $product->ProductDescription)
       );

     }


     $dataPoints = json_encode($dataPoints,JSON_NUMERIC_CHECK);
     return response()->json($dataPoints);
    }


    public function roundGraphsData(Request $request){

      $suppliers = Suppliers::all();
      $dataPoints = array();


      foreach($suppliers as $supplier){
        array_push($dataPoints,array("y" => ($supplier->TotalDeb),
        "name" => $supplier->CompanyName)
      );
    }


    $dataPoints = json_encode($dataPoints,JSON_NUMERIC_CHECK);
      return response()->json($dataPoints);
    }
}
