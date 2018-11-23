@extends('layouts.app')


@section('content')

<?php

$dataPoints = array(
	array("y" => 25, "label" => "Sunday"),
	array("y" => 15, "label" => "Monday"),
	array("y" => 25, "label" => "Tuesday"),
	array("y" => 5, "label" => "Wednesday"),
	array("y" => 10, "label" => "Thursday"),
	array("y" => 0, "label" => "Friday"),
	array("y" => 20, "label" => "Saturday")
);

?>

    <div class="text-center">


        <figure class="mt-5 figure container-fluid">
  <img src="img/map_portugal.png" class="figure-img img-fluid rounded" height="300" width="300">
  <figcaption class="figure-caption">Sales Value: <font color="green">GREEN</font> >=600 <br>
  <font color="blue">BLUE</font> >= 200 && < 600 <br>
<font color="red">RED</font> < 200 <br>
</figcaption>
</figure>

  <div class="border rounded border-success mr-5 d-inline-flex p-1 bd-highlight">Billing: </div>

  <div class="graph d-inline-flex m-5" id="chartContainer-Company growth-Company value-postajax" style="height: 300px; width: 50%;"></div>
	<script type="text/javascript" src="{{ URL::asset('js/graph.js') }}"></script>
        <div class="border rounded border-danger ml-5 d-inline-flex p-1 bd-highlight">Total expenditures: </div>


    </div>
@endsection
