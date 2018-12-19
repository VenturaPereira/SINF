@extends('layouts.app')

@section('content')

<link href="{{ URL::asset('css/financial.css') }}" rel="stylesheet">

<!-- Bootstrap core CSS-->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template-->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

<!-- Page level plugin CSS-->
<link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="css/sb-admin.css" rel="stylesheet">

<div class="text-center">
  <div class="BarGraph" id="inc_exp" >
    // With Lava class alias
    {!! \Lava::render('ColumnChart', 'Finances', 'inc_exp') !!}
  </div>
</div>

<!-- Icon Cards-->
<div class="row">
  <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white bg-primary o-hidden h-100">
      <div class="card-body">
        <div class="card-body-icon">
          <i class="fas fa-fw fa-money-check-alt"></i>
        </div>
        <div class="mr-5">Cash: <h3>{{round($cash,1)}}€</h3></div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white bg-warning o-hidden h-100">
      <div class="card-body">
        <div class="card-body-icon">
          <i class="fas fa-fw fa-sign-out-alt"></i>
        </div>
        <div class="mr-5">Cash Ratio: <h3>{{round( ($cash/$total_liabilities), 2)}}</h3></div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white bg-success o-hidden h-100">
      <div class="card-body">
        <div class="card-body-icon">
          <i class="fas fa-fw fa-users"></i>
        </div>
        <div class="mr-5">Total Assets: <h3>{{round($total_assets,1)}}€</h3></div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white bg-danger o-hidden h-100">
      <div class="card-body">
        <div class="card-body-icon">
          <i class="fas fa-fw fa-user-tie"></i>
        </div>
        <div class="mr-5">Total Liabilities: <h3>{{round($total_liabilities, 1)}}€</h3></div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white bg-danger o-hidden h-100">
      <div class="card-body">
        <div class="card-body-icon">
          <i class="fas fa-fw fa-user-tie"></i>
        </div>
        <div class="mr-5">Current Ratio: <h3>{{round( ($total_assets/$total_liabilities), 2)}}</h3></div>
      </div>
    </div>
  </div>
</div>

@endsection