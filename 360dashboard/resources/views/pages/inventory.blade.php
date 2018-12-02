@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/roundGraphs.js') }}"></script>
    <div>

      <div class="container-fluid">
        <h3>Top products by sales </h3>
        <table class="company_table">
    <tr>
      <th>#</th>
      <th>ID</th>
      <th>Product</th>
      <th>Quantity</th>
      <th>Client ID</th>
    </tr>

    <tr>
      <td>1</td>
      <td>101010</td>
      <td>Banana</td>
      <td>3</td>
      <td>1010</td>
    </tr>
    <tr>
      <td>1</td>
      <td>101010</td>
      <td>Banana</td>
      <td>3</td>
      <td>1010</td>
    </tr>
    <tr>
      <td>1</td>
      <td>101010</td>
      <td>Banana</td>
      <td>3</td>
      <td>1010</td>
    </tr>
  </table>
      </div>

      <div class="container-fluid">
        <h3>Stock </h3>
        <table class="company_table" id="stockTable">
    <tr>
      <th>#</th>
      <th>ID</th>
      <th>Product name</th>
      <th>Quantity</th>
    </tr>

    <?php $i=0; $stock_example=30;?>
    @if(count($products) > 1)
      @foreach($products as $product)
      <?php ++$i;?>
       @if($i < 7)
       <tr>
          <td>{{$i}}</td>
          <td>{{$product->ProductCode}}</td>
          <td>{{$product->ProductDescription}}</td>
          <td>{{$stock_example}}</td>
          <?php $stock_example = $stock_example*2;?>
        </tr>

      @else
        <tr style="display: none ">
          <td>{{$i}}</td>
          <td>{{$product->ProductCode}}</td>
          <td>{{$product->ProductDescription}}</td>
          <td>{{$stock_example}}</td>
          <?php $stock_example = $stock_example*2;?>
        </tr>
      @endif
      @endforeach
      <tr>
           <td colspan=4> <span onclick="toggle('stockTable',event)" style="cursor: pointer; color: blue" > View more </span> </td>
      </tr>
    @else
        <p>No Products found</p>
  @endif
  </table>
      </div>


      <div class="roundGraph d-inline-flex m-5" id="roundChartContainerInventory-postajaxRound" style="height: 300px; width: 50%;"> </div>
    </div>
@endsection



<script>
function toggle(id,event){

  var x= document.getElementById(id).rows;
  var el_span = event.target;

  for(var i=5; i < x.length-1; i++){
  if(x[i].style.display === ""){
    x[i].style.display = "none";
    el_span.innerHTML = "View more";
  } else {
    x[i].style.removeProperty('display');
    el_span.innerHTML = "View less";
  }
  }
}
</script>
