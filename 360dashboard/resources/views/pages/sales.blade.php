@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/graph.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/general.js') }}"></script>
<link href="{{ URL::asset('css/sales.css') }}" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <div>>

    <div class="container-fluid" id="clientsDiv">
      <h3>Top Clients </h3>
      @if(count($customers) > 1)
      <table class="company_table" id="clientsTable">
      <tr>
          <th>Company Name</th>
          <th>Money Spent</th>
          <th>Addition info</th>
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
  

     <!-- Modal content-->
<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header" align ="center" >
      <h3 class="modal-title" style="text-align: center; important!">Client Information</h3>
    </div>
    <div class="modal-body">
      <label style="font: normal 20px 'Bitter', serif; color: #2A88AD;">Name</label>
      <p class="Name"></p>
      <label style="font: normal 20px 'Bitter', serif; color: #2A88AD;">Customer Id</label>
      <p class="ClientID"></p>
      <label style="font: normal 20px 'Bitter', serif; color: #2A88AD;">Account Id</label>
      <p class="AccountID"></p>
      <label style="font: normal 20px 'Bitter', serif; color: #2A88AD;">NIF</label>
      <p class="Nif"></p>
      <label style="font: normal 20px 'Bitter', serif; color: #2A88AD;">Morada Faturacao</label>
      <p class="BillingAddressMorada"></p>
      <label style="font: normal 20px 'Bitter', serif; color: #2A88AD;">Codigo Postal Faturacao</label>
      <p class="BillingAddressPostCode"></p>
      <label style="font: normal 20px 'Bitter', serif; color: #2A88AD;">Pais Faturacao</label>
      <p class="BillingAddressCountry"></p>
      <label style="font: normal 20px 'Bitter', serif; color: #2A88AD;">Cidade Faturacao</label>
      <p class="BillingAddressCity"></p>
    </div>
    <div class="modal-footer">
      <button type="button" class="close" data-dismiss="modal">Close</button>
    </div>
  </div>

  <!-- End of Modal -->

 </div>
</div>
<script>

var modal = document.getElementById("myModal");
$(document).on('click', '.close', function(){
  modal.style.display = "none";
});
 $(document).on('click', '.viewPopLink', function() {    
    var user_id = $(this).data('id');
    $.ajax({
      url: '/SINF/360dashboard/public/sales/'+user_id,
      type: 'GET',
      dataType: 'JSON',
      success: function(data, textStatus, jqXHR){
        var name = data[0].CompanyName;
        var clientId = data[0].CustomerID;
        var customerTax = data[0].CustomerTaxID;
        var accountId = data[0].AccountID;
        var address = data[0].BillingAddress_AddressDetail;
        var city = data[0].BillingAddress_City;
        var postalCode = data[0].BillingAddress_PostalCode;
        var country = data[0].BillingAddress_Country;
        $('.Name').html('<span>' + name + '</span>');
        $('.ClientID').html('<span>' + clientId + '</span>');   
        $('.AccountID').html('<span>' + accountId + '</span>');   
        $('.Nif').html('<span>' + customerTax + '</span>');   
        $('.BillingAddressMorada').html('<span>' + address + '</span>');   
        $('.BillingAddressPostCode').html('<span>' + postalCode + '</span>');   
        $('.BillingAddressCountry').html('<span>' + country + '</span>');   
        $('.BillingAddressCity').html('<span>' + city + '</span>');   

        $('#myModal').modal('show');
      },
      error: function(jqXHR, textStatus, errorThrown){

      },
    });    
  });



</script>

@endsection