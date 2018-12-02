<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Products;

class AjaxController extends Controller
{
  public function graphsData(Request $request){
    $dataPoints = array(
    	array("y" => 25, "label" => "Sunday"),
    	array("y" => 15, "label" => "Monday"),
    	array("y" => 25, "label" => "Tuesday"),
    	array("y" => 5, "label" => "Wednesday"),
    	array("y" => 10, "label" => "Thursday"),
    	array("y" => 0, "label" => "Friday"),
    	array("y" => 20, "label" => "Saturday")
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
     "label" => $product->ProductDescription)
   );

 }


$dataPoints = json_encode($dataPoints,JSON_NUMERIC_CHECK);
   return response()->json($dataPoints);
}


public function roundGraphsData(Request $request){

$dataPoints = array(
    array("y" => 21, "label" => "Nuclear"),
    array("y" => 24.5, "label" => "Renewable"),
    array("y" => 9, "label" => "Coal"),
    array("y" => 3.1, "label" => "Other Fuels")
  );


$dataPoints = json_encode($dataPoints,JSON_NUMERIC_CHECK);
  return response()->json($dataPoints);
}
}
