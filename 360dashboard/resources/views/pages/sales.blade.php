@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/graph.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/roundGraphs.js') }}"></script>
<link href="{{ URL::asset('css/sales.css') }}" rel="stylesheet">
   

    <div>

    <div class="container-fluid" id="clientsDiv">
      <h3>Top Clients </h3>
      <table class="company_table" id="clientsTable">
      <tr>
          <th>ID</th>
          <th>Account ID</th>
          <th>Customer Tax Id</th>
        </tr>
       @if(count($customers) > 1)
       <?php $i=0; ?>
      @foreach($customers as $customer)
          <?php ++$i;?>
          @if($i < 5)
          <tr>
            <td>{{$customer->CustomerID}}</td>
            <td>{{$customer->AccountID}}</td>
            <td>{{$customer->CustomerTaxID}}</td>
          </tr>
          
          @else
          <tr style="display: none">
            <td>{{$customer->CustomerID}}</td>
            <td>{{$customer->AccountID}}</td>
            <td>{{$customer->CustomerTaxID}}</td>
          </tr>
        @endif
      @endforeach
      <tr>
           <td colspan=3> <span onclick="toggle('clientsTable')" style="cursor: pointer; color: blue" > View more </span> </td>
      </tr>
    @else
        <p>No Customers found</p>
    @endif
      </table>
    </div>

    <div class="container-fluid" id="productsDiv">
    
      <h3>Top Products </h3>
      <table class="company_table" id="productsTable">
  <tr>
    <th>Product Code</th>
    <th>Product Group</th>
    <th>Product Type</th>
  </tr>
  @if(count($products) > 1)
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
           <td colspan=3> <span onclick="toggle('productsTable')" style="cursor: pointer; color: blue" > View more </span> </td>
      </tr>
    @else
        <p>No Products found</p>
    @endif
</table>
    </div>


    <div class="container-fluid" id = "activesDiv">
      <h3>Most active Clients </h3>
      <table class="company_table" >
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

<div class="container-fluid" id="salesGraph">
  <h3 class="text-center">Sales</h3>
    <div class="roundGraph d-inline-flex m-5" id="roundChartContainer-postajaxRound" > </div>
    <div class="graph d-inline-flex m-5" id="chartContainerSales--Sales-postajax"></div>


    </div>
@endsection

<script>

function toggle(id){
  console.log(id);
  var x= document.getElementById(id).rows;

  for(var i=5; i < x.length-1; i++){
  if(x[i].style.display === ""){
    x[i].style.display = "none";
  } else {
    x[i].style.removeProperty('display');
  }
  }
}



</script>