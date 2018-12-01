@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/graph.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/roundGraphs.js') }}"></script>

    @if(count($customers) > 1)
      @foreach($customers as $customer)
        <div class="well">
          <p>CustomerID: {{$customer->CustomerID}}</p>
          <p>AccountID: {{$customer->AccountID}}</p>
          <p>CustomerTaxID: {{$customer->CustomerTaxID}}</p>
          <p>-------------</p>
        </div>
      @endforeach
    @else
        <p>No Customers found</p>
    @endif

    <div>

    <div class="container-fluid">
      <h3>Top Clients </h3>
      <table class="company_table">
  <tr>
    <th>#</th>
    <th>First Name</th>
    <th>Client Number</th>
  </tr>
  <tr>
    <td>1</td>
    <td>Maria LDSA</td>
    <td>101010</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Maria LDSA</td>
    <td>101010</td>
  </tr>
  <tr>
    <td>3</td>
    <td>Maria LDSA</td>
    <td>101010</td>
  </tr>
</table>
    </div>


    <div class="container-fluid">
      <h3>Top Products </h3>
      <table class="company_table">
  <tr>
    <th>#</th>
    <th>Product Name</th>
    <th>Amount</th>
    <th>Client Id</th>
  </tr>
  <tr>
    <td>1</td>
    <td>Banana</td>
    <td>500</td>
    <td>101010</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Orange</td>
    <td>500</td>
    <td>101010</td>
  </tr>
  <tr>
    <td>3</td>
    <td>Banana</td>
    <td>500</td>
    <td>101010</td>
  </tr>
</table>
    </div>


    <div class="container-fluid">
      <h3>Most active Clients </h3>
      <table class="company_table">
  <tr>
    <th>#</th>
    <th>First Name</th>
    <th>Client Number</th>
  </tr>
  <tr>
    <td>1</td>
    <td>Maria LDSA</td>
    <td>101010</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Maria LDSA</td>
    <td>101010</td>
  </tr>
  <tr>
    <td>3</td>
    <td>Maria LDSA</td>
    <td>101010</td>
  </tr>
</table>
    </div>

<div>
  <h3 class="text-center">Sales</h3>
    <div class="roundGraph d-inline-flex m-5" id="roundChartContainer-postajaxRound" style="height: 300px; width: 50%;"> </div>
    <div class="graph d-inline-flex m-5" id="chartContainerSales--Sales-postajax" style="height: 300px; width: 50%;"></div>


    </div>
@endsection
