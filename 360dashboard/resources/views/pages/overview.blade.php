@extends('layouts.app')


@section('content')
<link href="{{ URL::asset('css/overview.css') }}" rel="stylesheet">
<script type="text/javascript" src="{{ URL::asset('js/graph.js') }}"></script>

   
    <div id="first">
        <figure id="figure" class="mt-5 figure container-fluid">
            <img src="img/map_portugal.png" class="figure-img img-fluid rounded" height="300" width="300">
            <figcaption class="figure-caption">Sales Value: <font color="green">GREEN</font> >=600 <br>
                    <font color="blue">BLUE</font> >= 200 && < 600 <br>
                    <font color="red">RED</font> < 200 <br>
            </figcaption>
        </figure>
    </div>


        <div id="billing" class="border rounded border-success mr-5 d-inline-flex p-1 bd-highlight">Cash: 191.000.000 </div>
        <div id="expenditures" class="border rounded border-danger ml-5 d-inline-flex p-1 bd-highlight">Total expenditures: 33 </div>
        <div class="graph d-inline-flex m-5" id="chartContainer-Company growth-Company value-postajax" style="height: 300px; width: 50%;"></div>


   
@endsection
