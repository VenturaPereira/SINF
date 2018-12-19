@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/roundGraphs.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/general.js') }}"></script>
<link href="{{ URL::asset('css/inventory.css') }}" rel="stylesheet">

    <div>

      <div class="productsSales">
        <h3>Top products by sales </h3>

        @if(count($products_sales) > 1)
        <table class="company_table" id="salesTable" >

    <tr>
      <th>Product name</th>
      <th>Nr of Sales</th>
      <th>Additional info</th>
    </tr>

    <?php $i=0;?>
      @foreach($products_sales as $product)
      <?php ++$i;?>
       @if($i < 5)
       <tr>
          <td>{{$product->ProductDescription}}</td>
          <td>{{$product->totals}}</td>
          <td><button style="background-color: #4CAF50; color: white; cursor: pointer; border-radius: 4px;" type="button" class="viewMoreInfo" role="button" data-id="{{ $product->ProductDescription }}" data-toggle="modal" data-target="#myModal">Additional Info</button></td> 
        </tr>

      @else
        <tr style="display: none ">
          <td>{{$product->ProductDescription}}</td>
          <td>{{$product->totals}}</td>
          <td><button style="background-color: #4CAF50; color: white; cursor: pointer; border-radius: 4px;" type="button" class="viewMoreInfo" role="button" data-id="{{ $product->ProductDescription }}" data-toggle="modal" data-target="#myModal">Additional Info</button></td> 
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

      <div class="stockProducts">
        <h3>Stock </h3>
        @if(count($products_stock) > 1)
        <table class="company_table" id="stockTable">
    <tr>

      <th>Product name</th>
      <th>Quantity</th>
    </tr>

    <?php $i=0;?>
      @foreach($products_stock as $product)
      <?php ++$i;?>
       @if($i < 5)
       <tr>
          <td>{{$product->ProductDescription}}</td>
          @if($product->ProductStkCurrent < 35)
          <td style="color:red;">{{$product->ProductStkCurrent}}</td>
          @elseif($product->ProductStkCurrent > 80)
          <td style="color:green;">{{$product->ProductStkCurrent}}</td>
          @else
          <td>{{$product->ProductStkCurrent}}</td>
          @endif
        </tr>

      @else
        <tr style="display: none ">
          <td>{{$product->ProductDescription}}</td>
          @if($product->ProductStkCurrent < 35)
          <td style="color:red;">{{$product->ProductStkCurrent}}</td>
          @elseif($product->ProductStkCurrent > 80)
          <td style="color:green;">{{$product->ProductStkCurrent}}</td>
          @else
          <td>{{$product->ProductStkCurrent}}</td>
          @endif
        </tr>
      @endif
      @endforeach
      <tr>
           <td colspan=4> <span onclick="toggle('stockTable-11',event)" style="cursor: pointer; color: blue" > View more </span> </td>
      </tr>
    @else
        <h5>No Products found</h5>
  @endif
  </table>
</div>

  <div class="graphC" id="my-dash">
        <div id="chart">
        </div>
        <div id="control">
        </div>
    </div>
  {!! \Lava::render('Dashboard', 'Gross Value', 'my-dash') !!}


    <!-- Modal content-->
<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header" align ="center" >
      <h3 class="modal-title" style="text-align: center; important!"></h3>
    </div>
    <div class="modal-body" id="body">
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
    </div>
  </div>

  <!-- End of Modal -->






<script>

var modal = document.getElementById("myModal");

$(document).on('click', '.close', function(){
  $("#body").html("");
  $('#myModal').modal('hide');
  
        
});




 $(document).on('click', '.viewMoreInfo', function() {    
    var product_name = $(this).data('id');
    $("#body").html("");
    $.ajax({
      url: '/SINF/360dashboard/public/inventory/'+product_name,
      type: 'GET',
      dataType: 'JSON',
      success: function(data, textStatus, jqXHR){
       
        $('.modal-title').html('<span> Informacao Produto </span>');
       
        var name = $("<p></p>").text("Descricao Produto");
        var nameValue = $("<span></span>").text(data[0][0].ProductDescription);
        var productGroup = $("<p></p>").text("Grupo Produto");
        var productGroupValue = $("<span></span>").text(data[0][0].ProductGroup);
        var productType = $("<p></p>").text("Tipo Produto");
        var productTypeValue = $("<span></span>").text(data[0][0].ProductType);
        var productCode = $("<p></p>").text("Codigo Produto");
        var productCodeValue = $("<span></span>").text(data[0][0].ProductCode);
        var productStock = $("<p></p>").text("Stock Atual");
        var productStockValue = $("<span></span>").text(data[0][0].ProductStkCurrent);
        var productPrice = $("<p></p>").text("Preco");
        var productPriceValue = $("<span></span>").text(data[0][0].ProductUnitaryPrice);
        var moneyGenerated = $("<p></p>").text("Revenue Produto");
        var moneyGeneratedValue = $("<span></span>").text(data[1][0].revenue +"€");
        var lastdate = $("<p></p>").text("Ultima Compra");
        var lasteDateValue = $("<span></span>").text(data[3][0].InvoiceDate);
        var topBuyers = $("<table class='top_buyers' id='topBuyers'>");
        var header = $("<tr></tr>");
        var headerLine=$("<th></th>").text("Comprador");
        var headerLineTwo=$("<th></th>").text("Quantidade");
        

        $('#body').append(name);
        $('#body').append(nameValue);
        $('#body').append(productGroup);
        $('#body').append(productGroupValue);
        $('#body').append(productType);
        $('#body').append(productTypeValue);
        $('#body').append(productCode);
        $('#body').append(productCodeValue);
        $('#body').append(productStock);
        $('#body').append(productStockValue);
        $('#body').append(productPrice);
        $('#body').append(productPriceValue);
        $('#body').append(moneyGenerated);
        $('#body').append(moneyGeneratedValue);
        $('#body').append(lastdate);
        $('#body').append(lasteDateValue);
        $('#body').append(topBuyers);
        $(topBuyers).append(header);
        $(header).append(headerLine);
        $(header).append(headerLineTwo);
        for(var i =0; i < data[2].length;i++){
          var line = $("<tr></tr>");
          var lineValue = $("<td></td>").text(data[2][i].cid);
          var lineValueTwo = $("<td></td>").text(data[2][i].totalQuantity);
          $(topBuyers).append(line);
          $(line).append(lineValue);
          $(line).append(lineValueTwo);
        }
        
        
        $('#myModal').modal('show');
      },
      error: function(jqXHR, textStatus, errorThrown){

      },
    });    
  });





</script>


<style>

p {style=font: normal 20px 'Bitter', serif; 
color: #2A88AD;}
</style>


@endsection
