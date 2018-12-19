@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/BarsGraph.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/BarsGraphFinance.js') }}"></script>
<link href="{{ URL::asset('css/financial.css') }}" rel="stylesheet">

    <div class="text-center">
      <div class="BarGraph" id="inc_exp" >
        // With Lava class alias
        {!! \Lava::render('ColumnChart', 'Finances', 'inc_exp') !!}
      </div>
    </div>

    <div class="container-fluid" id="debtDiv">
      <h3>Cash</h3>
      <h5>{{round($cash,1)}}</h5>
    </div>

    <div class="container-fluid" id="debtDiv">
      <h3>Cash Ratio</h3>
      <h5>{{round( ($cash/$total_liabilities), 2)}}</h5>
    </div>

    <div class="container-fluid" id="debtDiv">
      <h3>Total Assets</h3>
      <h5>{{round($total_assets,1)}}</h5>
    </div>

    <div class="container-fluid" id="debtDiv">
      <h3>Total Liabilities</h3>
      <h5>{{round($total_liabilities, 1)}}</h5>
    </div>

    <div class="container-fluid" id="debtDiv">
      <h3>Current Ratio</h3>
      <h5>{{round( ($total_assets/$total_liabilities), 2)}}</h5>
    </div>
    
@endsection
