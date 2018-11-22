<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
  public function post(Request $request){
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
}
