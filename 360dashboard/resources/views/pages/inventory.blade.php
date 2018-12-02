@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/roundGraphs.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/general.js') }}"></script>
    <div>

      <div class="container-fluid">
        <h3>Top products by sales </h3>

        @if(count($products_sales) > 1)
        <table class="company_table" id="salesTable" >
    <tr>
      <th>#</th>
      <th>ID</th>
      <th>Product name</th>
      <th>Sales number</th>
    </tr>

    <?php $i=0;?>
      @foreach($products_sales as $product)
      <?php ++$i;?>
       @if($i < 11)
       <tr>
          <td>{{$i}}</td>
          <td>{{$product->ProductCode}}</td>
          <td>{{$product->ProductDescription}}</td>
          <td>{{$product->ProductSales}}</td>
        </tr>

      @else
        <tr style="display: none ">
          <td>{{$i}}</td>
          <td>{{$product->ProductCode}}</td>
          <td>{{$product->ProductDescription}}</td>
          <td>{{$product->ProductQuantity}}</td>
        </tr>
      @endif
      @endforeach
      <tr>
           <td colspan=4> <span onclick="toggle('salesTable-11',event)" style="cursor: pointer; color: blue" > View more </span> </td>
      </tr>
    @else
        <h5>No Products found</h5>
  @endif
  </table>
      </div>

      <div class="container-fluid">
        <h3>Stock </h3>
        @if(count($products_stock) > 1)
        <table class="company_table" id="stockTable">
    <tr>
      <th>#</th>
      <th>ID</th>
      <th>Product name</th>
      <th>Quantity</th>
    </tr>

    <?php $i=0;?>
      @foreach($products_stock as $product)
      <?php ++$i;?>
       @if($i < 6)
       <tr>
          <td>{{$i}}</td>
          <td>{{$product->ProductCode}}</td>
          <td>{{$product->ProductDescription}}</td>
          <td>{{$product->ProductQuantity}}</td>
        </tr>

      @else
        <tr style="display: none ">
          <td>{{$i}}</td>
          <td>{{$product->ProductCode}}</td>
          <td>{{$product->ProductDescription}}</td>
          <td>{{$product->ProductQuantity}}</td>
        </tr>
      @endif
      @endforeach
      <tr>
           <td colspan=4> <span onclick="toggle('stockTable-6',event)" style="cursor: pointer; color: blue" > View more </span> </td>
      </tr>
    @else
        <h5>No Products found</h5>
  @endif
  </table>
      </div>


      <div class="roundGraph d-inline-flex m-5" id="roundChartContainerInventory-postajaxRoundStock" style="height: 350px; width: 70%;"> </div>
    </div>
@endsection
