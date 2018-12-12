@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/graph.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/roundGraphs.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/general.js') }}"></script>
<link href="{{ URL::asset('css/sales.css') }}" rel="stylesheet">
    <div>

      <div class="container-fluid" id="clientsDiv">
        <h3>Top Suppliers </h3>
        @if(count($suppliers) > 1)
        <table class="company_table" id="clientsTable">
        <tr>
            <th>ID</th>
            <th>Account ID</th>
            <th>Supplier Name</th>
          </tr>

         <?php $i=0; ?>

        @foreach($suppliers as $supplier)
            <?php ++$i;?>
            @if($i < 5)
            <tr>
              <td>{{$supplier->SupplierID}}</td>
              <td>{{$supplier->SupplierTaxID}}</td>
              <td>{{$supplier->CompanyName}}</td>
            </tr>

            @else
            <tr style="display: none">
              <td>{{$supplier->SupplierID}}</td>
              <td>{{$supplier->SupplierTaxID}}</td>
              <td>{{$supplier->CompanyName}}</td>
            </tr>
            @endif
        @endforeach
        @if(count($suppliers) >= 5)
        <tr>
             <td colspan=3> <span onclick="toggle('clientsTable-5',event)"  style="cursor: pointer; color: blue" > View more </span> </td>
        </tr>
        @endif
      @else
          <h5>No Suppliers found</h5>
      @endif
        </table>
      </div>

      <div class="container-fluid" id="productsDiv">

        <h3>Top Products </h3>
        @if(count($products) > 1)
        <table class="company_table" id="productsTable">
    <tr>
      <th>Product Code</th>
      <th>Product Description</th>
      <th>Product Price</th>
    </tr>
    <?php $i=0; ?>
        @foreach($products as $product)
        <?php ++$i;?>
         @if($i < 5)
         <tr>
            <td>{{$product->ProductCode}}</td>
            <td>{{$product->ProductDescription}}</td>
            <td>{{$product->ProductPrice}}</td>
          </tr>

        @else
          <tr style="display: none ">
            <td>{{$product->ProductCode}}</td>
            <td>{{$product->ProductDescription}}</td>
            <td>{{$product->ProductPrice}}</td>
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


@if(count($suppliers) > 1)
    <div class="container-fluid" id="salesGraph">
      <h3>Supplies</h3>
        <div class="graph d-inline-flex" id="chartContainerSupplies--Buys-postajax"></div>
    </div>


      <div class="roundGraph d-inline-flex float-right" style="margin-top: 0%;margin-right: 40%;" id="roundChartContainerSupplies-postajaxRound-Total Gross/Supplier-In $" style="height: 300px; width: 50%;"> </div>
@endif

        </div>
@endsection
