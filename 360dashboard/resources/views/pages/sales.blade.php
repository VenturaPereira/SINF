@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/graph.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/general.js') }}"></script>
<link href="{{ URL::asset('css/sales.css') }}" rel="stylesheet">


    <div>

    <div class="container-fluid" id="clientsDiv">
      <h3>Top Clients </h3>
      @if(count($customers) > 1)
      <table class="company_table" id="clientsTable">
      <tr>
          <th>ID</th>
          <th>Account ID</th>
          <th>Customer Name</th>
        </tr>

       <?php $i=0; ?>

      @foreach($customers as $customer)
          <?php ++$i;?>
          @if($i < 5)
          <tr>
            <td>{{$customer->CustomerID}}</td>
            <td>{{$customer->AccountID}}</td>
            <td>{{$customer->CompanyName}}</td>
          </tr>

          @else
          <tr style="display: none">
            <td>{{$customer->CustomerID}}</td>
            <td>{{$customer->AccountID}}</td>
            <td>{{$customer->CompanyName}}</td>
          </tr>
          @endif
      @endforeach
      <tr>
           <td colspan=3> <span onclick="toggle('clientsTable-5',event)"  style="cursor: pointer; color: blue" > View more </span> </td>
      </tr>
    @else
        <h5>No Customers found</h5>
    @endif
      </table>
    </div>

    <div class="container-fluid" id="productsDiv">

      <h3>Top Products </h3>
      @if(count($products) > 1)
      <table class="company_table" id="productsTable">
  <tr>
    <th>Product Code</th>
    <th>Product Group</th>
    <th>Product Type</th>
  </tr>
  <?php $i=0; ?>
      @foreach($products as $product)
      <?php ++$i;?>
       @if($i < 5)
       <tr>
          <td>{{$product->ProductCode}}</td>
          <td>{{$product->ProductGroup}}</td>
          <td>{{$product->ProductType}}</td>
        </tr>

      @else
        <tr style="display: none ">
          <td>{{$product->ProductCode}}</td>
          <td>{{$product->ProductGroup}}</td>
          <td>{{$product->ProductType}}</td>
        </tr>
      @endif
      @endforeach
      <tr>
           <td colspan=3> <span onclick="toggle('productsTable-5',event)"  style="cursor: pointer; color: blue" > View more </span> </td>
      </tr>
    @else
        <h5>No Products found</h5>
  @endif
</table>
    </div>


    <div class="container-fluid" id = "activesDiv">
      <h3>Most active Clients </h3>
      @if(count($customers) > 1)
      <table class="company_table" >
        <tr>
            <th>ID</th>
            <th>Account ID</th>
            <th>Customer Name</th>
          </tr>

         <?php $i=0; ?>


        @foreach($customers as $customer)
            <?php ++$i;?>
            @if($i < 5)
            <tr>
              <td>{{$customer->CustomerID}}</td>
              <td>{{$customer->AccountID}}</td>
              <td>{{$customer->CompanyName}}</td>
            </tr>

            @else
            <tr style="display: none">
              <td>{{$customer->CustomerID}}</td>
              <td>{{$customer->AccountID}}</td>
              <td>{{$customer->CompanyName}}</td>
            </tr>
            @endif
        @endforeach
      @else
          <h5>No Customers found</h5>
      @endif
</table>
    </div>

@if(count($customers) > 1)
<div class="container-fluid" id="salesGraph">
  <h3>Sales</h3>
  {!! \Lava::render('LineChart', 'Sales', 'salesGraph') !!}
</div>
@endif

    </div>
@endsection
