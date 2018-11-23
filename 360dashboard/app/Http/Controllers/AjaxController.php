<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

 public function roundGraphsData(Request $request){

   $dataPoints = array(
     array("y" => 42, "label" => "Gas"),
     array("y" => 21, "label" => "Nuclear"),
     array("y" => 24.5, "label" => "Renewable"),
     array("y" => 9, "label" => "Coal"),
     array("y" => 3.1, "label" => "Other Fuels")
   );


$dataPoints = json_encode($dataPoints,JSON_NUMERIC_CHECK);
   return response()->json($dataPoints);
}
}
