@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/graph.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/general.js') }}"></script>
<link href="{{ URL::asset('css/sales.css') }}" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
--> <div class="containerC">

    <div id="clientsDiv" class="clientsDivC">
      <h3>Top Clients </h3>
      @if(count($customers) > 1)
      <table class="company_table" id="clientsTable">
      <tr>
          <th>Company Name</th>
          <th>Money Spent</th>
          <th>Additional info</th>
        </tr>

       <?php $i=0; ?>

      @foreach($customers as $customer)
          <?php ++$i;?>
          @if($i < 5)
          <tr>
            <td>{{$customer->CompanyName}}</td>
            <td>{{$customer->total}}€</td>
            <td><button style="background-color: #4CAF50; color: white; cursor: pointer; border-radius: 4px;" type="button" class="viewPopLink" role="button" data-id="{{ $customer->CustomerID }}" data-toggle="modal" data-target="#myModal">Additional Info</button></td> 
            </tr>

          @else
          <tr style="display: none">
            <td>{{$customer->CompanyName}}</td>
            <td>{{$customer->total}}€</td>
            <td><button style="background-color: #4CAF50; color: white; cursor: pointer; border-radius: 4px;" type="button" class="viewPopLink" role="button" data-id="{{ $customer->CustomerID  }}" data-toggle="modal" data-target="#myModal">Additional Info</button></td>       
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

    <div id="productsDiv"  class="productsDivC">

      <h3>Top Products </h3>
      @if(count($products) > 1)
      <table class="company_table" id="productsTable">
  <tr>
    <th>Product Name</th>
    <th>Product Revenue</th>
    <th>Additional info</th>
  </tr>
  <?php $i=0; ?>
      @foreach($products as $product)
      <?php ++$i;?>
       @if($i < 5)
       <tr>
          <td>{{$product->ProductDescription}}</td>
          <td>{{$product->totalPrice}}€</td>
          <td><button style="background-color: #4CAF50; color: white; cursor: pointer; border-radius: 4px;" type="button" class="viewPopLinkProduct" role="button" data-id="{{ $product->ProductDescription  }}" data-toggle="modal" data-target="#myModal">Additional Info</button></td>       

        </tr>

      @else
        <tr style="display: none ">
          <td>{{$product->ProductDescription}}</td>
          <td>{{$product->totalPrice}}€</td>
          <td><button style="background-color: #4CAF50; color: white; cursor: pointer; border-radius: 4px;" type="button" class="viewPopLinkProduct" role="button" data-id="{{ $product->ProductDescription  }}" data-toggle="modal" data-target="#myModal">Additional Info</button></td>       

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

    
    <div id = "activesDiv" class ="activesDivC">
      <h3>Most active Clients </h3>
      @if(count($customers) > 1)
      <table class="company_table" >
        <tr>
            <th>Nome Consumidor</th>
            <th>Numero de Faturas</th>
          </tr>

         <?php $i=0; ?>


        @foreach($actifs as $actif)
            <?php ++$i;?>
            @if($i < 5)
            <tr>
              <td>{{$actif->CompanyName}}</td>
              <td>{{$actif->counter}}</td>
            </tr>

            @else
            <tr style="display: none">
              <td>{{$actif->CompanyName}}</td>
              <td>{{$actif->counter}}</td>
            </tr>
            @endif
        @endforeach
      @else
          <h5>No Customers found</h5>
      @endif
</table>


    </div>
    <div id="my-dash" class="dashC">
        <div id="chart">
        </div>
        <div id="control">
        </div>
    </div>
  {!! \Lava::render('Dashboard', 'Invoices', 'my-dash') !!}
@if(count($customers) > 1)
<div  id="salesGraph" class="salesC">
  <h3>Sales</h3>
  {!! \Lava::render('LineChart', 'Sales', 'salesGraph') !!}
</div>
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
</div>
<script>








var modal = document.getElementById("myModal");

$(document).on('click', '.close', function(){
  $("#body").html("");
  $('#myModal').modal('hide');
  
        
});


 $(document).on('click', '.viewPopLinkProduct', function() {    
    var product_name = $(this).data('id');
    $("#body").html("");
    $.ajax({
      url: '/SINF/360dashboard/public/sales/product/'+product_name,
      type: 'GET',
      dataType: 'JSON',
      success: function(data, textStatus, jqXHR){
       
        $('.modal-title').html('<span> Informacao Produto </span>');
       
        var name = $("<p></p>").text("Descricao Produto");
        var nameValue = $("<span></span>").text(data[0].ProductDescription);
        var productGroup = $("<p></p>").text("Grupo Produto");
        var productGroupValue = $("<span></span>").text(data[0].ProductGroup);
        var productType = $("<p></p>").text("Tipo Produto");
        var productTypeValue = $("<span></span>").text(data[0].ProductType);
        var productCode = $("<p></p>").text("Codigo Produto");
        var productCodeValue = $("<span></span>").text(data[0].ProductCode);
        var productStock = $("<p></p>").text("Stock Atual");
        var productStockValue = $("<span></span>").text(data[0].ProductQuantity);
        var productPrice = $("<p></p>").text("Preco");
        var productPriceValue = $("<span></span>").text(data[0].ProductUnitaryPrice);
        var moneyGenerated = $("<p></p>").text("Revenue Produto");
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
    $("#body").html("");
    $.ajax({
      url: '/SINF/360dashboard/public/sales/'+user_id,
      type: 'GET',
      dataType: 'JSON',
      success: function(data, textStatus, jqXHR){
 

        $('.modal-title').html('<span> Informacao Cliente </span>');
        
        var name = $("<p></p>").text("Name");
        var nameValue = $("<span></span>").text(data[0][0].CompanyName);
        var iDcliente = $("<p></p>").text("Id Cliente");
        var iDclienteValue = $("<span></span>").text(data[0][0].CustomerID);
        var iDconta = $("<p></p>").text("Id Conta");
        var iDcontaValue = $("<span></span>").text(data[0][0].AccountID);
        var nif = $("<p></p>").text("NIF");
        var nifValue = $("<span></span>").text(data[0][0].CustomerTaxID);
        var address = $("<p></p>").text("Morada Faturacao");
        var addressValue = $("<span></span>").text(data[0][0].BillingAddress_AddressDetail);
        var city = $("<p></p>").text("Cidade Faturacao");
        var cityValue = $("<span></span>").text(data[0][0].BillingAddress_City);
        var postalCode = $("<p></p>").text("Codigo Postal Faturacao");
        var postalCodeValue = $("<span></span>").text(data[0][0].BillingAddress_PostalCode);
        var country = $("<p></p>").text("Pais Faturacao");
        var countryValue = $("<span></span>").text(data[0][0].BillingAddress_Country);
        var numberOfPurchases =$("<p></p>").text("Numero de registos de compra");
        var numberOfPurchasesValue = $("<span></span>").text(data[1][0].entries);
        var productsBought = $("<table class='products_bought' id='productsPurchased'>");
        var header = $("<tr></tr>");
        var headerLine=$("<th></th>").text("Produtos Comprados");
        var headerLineTwo=$("<th></th>").text("Quantidade");
               

        $('#body').append(name);
        $('#body').append(nameValue);
        $('#body').append(iDcliente);
        $('#body').append(iDclienteValue);
        $('#body').append(iDconta);
        $('#body').append(iDcontaValue);
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
          var lineValue = $("<td></td>").text(data[2][i].ProductDescription);
          var lineValueTwo = $("<td></td>").text(data[2][i].Quantity);
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


<!-- query para atividade cliente -->
<!--SELECT COUNT(CustomerID), CustomerID, MONTH(invoices.InvoiceDate) FROM `invoices` GROUP BY CustomerID-->
