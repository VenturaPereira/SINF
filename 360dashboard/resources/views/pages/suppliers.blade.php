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
            <th>Supplier Name</th>
            <th>Additional info</th>
          </tr>

         <?php $i=0; ?>

        @foreach($suppliers as $supplier)
            <?php ++$i;?>
            @if($i < 5)
            <tr>
              <td>{{$supplier->SupplierID}}</td>
              <td>{{$supplier->CompanyName}}</td>
              <td><button style="background-color: #4CAF50; color: white; cursor: pointer; border-radius: 4px;" type="button" class="viewPopLink" role="button" data-id="{{ $supplier->SupplierID }}" data-toggle="modal" data-target="#myModal">Additional Info</button></td>
            </tr>

            @else
            <tr style="display: none">
              <td>{{$supplier->SupplierID}}</td>
              <td>{{$supplier->CompanyName}}</td>
              <td><button style="background-color: #4CAF50; color: white; cursor: pointer; border-radius: 4px;" type="button" class="viewPopLink" role="button" data-id="{{ $supplier->SupplierID }}" data-toggle="modal" data-target="#myModal">Additional Info</button></td>
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
      <th>Product Description</th>
      <th>Product Unitary Price</th>
      <th>Total spent on Product</th>
      <th>Additional info</th>
    </tr>
    <?php $i=0; ?>
        @foreach($products as $product)
        <?php ++$i;?>
         @if($i < 5)
         <tr>
            <td>{{$product->ProductDescription}}</td>
            <td>{{$product->ProductUnitaryPrice}}</td>
            <td>{{$product->totalPrice}}</td>
            <td><button style="background-color: #4CAF50; color: white; cursor: pointer; border-radius: 4px;" type="button" class="viewPopLinkProduct" role="button" data-id="{{ $product->ProductDescription  }}" data-toggle="modal" data-target="#myModal">Additional Info</button></td>
          </tr>

        @else
          <tr style="display: none ">
            <td>{{$product->ProductDescription}}</td>
            <td>{{$product->ProductUnitaryPrice}}</td>
            <td>{{$product->totalPrice}}</td>
            <td><button style="background-color: #4CAF50; color: white; cursor: pointer; border-radius: 4px;" type="button" class="viewPopLinkProduct" role="button" data-id="{{ $product->ProductDescription  }}" data-toggle="modal" data-target="#myModal">Additional Info</button></td>
          </tr>
        @endif
        @endforeach
        <tr>
             <td colspan=4> <span onclick="toggle('productsTable-5',event)"  style="cursor: pointer; color: blue" > View more </span> </td>
        </tr>
      @else
          <h5>No Products found</h5>
    @endif
  </table>
    </div>




@if(count($suppliers) > 1)
<div class="container-fluid float-left" id="salesGraph">
  <h3>Supplies</h3>
  {!! \Lava::render('LineChart', 'Buys', 'salesGraph') !!}
</div>

  <div class="roundGraph d-inline-flex float-right" style="margin-top: 20%;margin-right: 70%;" id="roundChartContainerSupplies-postajaxRound-Total Debt/Supplier-In $" style="height: 300px; width: 50%;"> </div>

  <div id="my-dash">
      <div id="chart">
      </div>
      <div id="control">
      </div>
  </div>
{!! \Lava::render('Dashboard', 'Gross', 'my-dash') !!}

@endif

        </div>


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

 </div>

<script>








var modal = document.getElementById("myModal");

$(document).on('click', '.close', function(){
  $("#body").html("");
  $('#myModal').modal('hide');


});


 $(document).on('click', '.viewPopLinkProduct', function() {
    var product_name = $(this).data('id');

    $.ajax({
      url: '/SINF/360dashboard/public/suppliers/product/'+product_name,
      type: 'GET',
      dataType: 'JSON',
      success: function(data, textStatus, jqXHR){

        $('.modal-title').html('<span> Informacao Produto </span>');

        var name = $("<p></p>").text("Descricao Produto");
        var nameValue = $("<span></span>").text(data[0].ProductDescription);
        var productGroup = $("<p></p>").text("Grupo Produto");
        var productGroupValue = $("<span></span>").text(data[0].ProducGroup);
        var productType = $("<p></p>").text("Tipo Produto");
        var productTypeValue = $("<span></span>").text(data[0].ProductType);
        var productCode = $("<p></p>").text("Codigo Produto");
        var productCodeValue = $("<span></span>").text(data[0].ProductCode);
        var productStock = $("<p></p>").text("Stock Atual");
        var productStockValue = $("<span></span>").text(data[0].ProductQuantity);
        var productPrice = $("<p></p>").text("Preco unitário");
        var productPriceValue = $("<span></span>").text(data[0].ProductUnitaryPrice);
        var moneyGenerated = $("<p></p>").text("Total gasto no Produto");
        var moneyGeneratedValue = $("<span></span>").text(data[0].totalPrice +"€");

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


        $('#myModal').modal('show');
      },
      error: function(jqXHR, textStatus, errorThrown){

      },
    });
  });


 $(document).on('click', '.viewPopLink', function() {
    var user_id = $(this).data('id');
    $.ajax({
      url: '/SINF/360dashboard/public/suppliers/'+user_id,
      type: 'GET',
      dataType: 'JSON',
      success: function(data, textStatus, jqXHR){


        $('.modal-title').html('<span> Informacao Fornecedor </span>');

        var name = $("<p></p>").text("Name");
        var nameValue = $("<span></span>").text(data[0][0].CompanyName);
        var iDsupplier = $("<p></p>").text("Id Supplier");
        var iDsupplierValue = $("<span></span>").text(data[0][0].SupplierID);
        var nif = $("<p></p>").text("NIF");
        var nifValue = $("<span></span>").text(data[0][0].SupplierTaxID);
        var address = $("<p></p>").text("Billing Address");
        var addressValue = $("<span></span>").text(data[0][0].BillingAddress_AddressDetail);
        var city = $("<p></p>").text("Billing City");
        var cityValue = $("<span></span>").text(data[0][0].BillingAddress_City);
        var postalCode = $("<p></p>").text("Billing Postal Code");
        var postalCodeValue = $("<span></span>").text(data[0][0].BillingAddress_PostalCode);
        var country = $("<p></p>").text("Billing Country");
        var countryValue = $("<span></span>").text(data[0][0].BillingAddress_Country);
        var numberOfPurchases =$("<p></p>").text("Number of buys register");
        var numberOfPurchasesValue = $("<span></span>").text(data[1][0].entries);
        var productsBought = $("<table class='products_bought' id='productsPurchased'>");
        var header = $("<tr></tr>");
        var headerLine=$("<th></th>").text("Bought products");
        var headerLineTwo=$("<th></th>").text("Quantity");


        $('#body').append(name);
        $('#body').append(nameValue);
        $('#body').append(iDsupplier);
        $('#body').append(iDsupplierValue);
        $('#body').append(nif);
        $('#body').append(nifValue);
        $('#body').append(address);
        $('#body').append(addressValue);
        $('#body').append(postalCode);
        $('#body').append(postalCodeValue);
        $('#body').append(country);
        $('#body').append(countryValue);
        $('#body').append(city);
        $('#body').append(cityValue);
        $('#body').append(numberOfPurchases);
        $('#body').append(numberOfPurchasesValue);
        $('#body').append(productsBought);
        $(productsBought).append(header);
        $(header).append(headerLine);
        $(header).append(headerLineTwo);
        for(var i =0; i < data[2].length;i++){
          var line = $("<tr></tr>");
          var lineValue = $("<td></td>").text(data[2][i].Descricao);
          var lineValueTwo = $("<td></td>").text(data[2][i].Quantidade);
          $(productsBought).append(line);
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
