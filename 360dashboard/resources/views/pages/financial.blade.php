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
      <h3>Cash Related </h3>
      <table class="company_table" id="CashTable">
        <tr>
            <th>Cash</th>
            <th>Cash Ratio</th>
        </tr>
        <tr>
             <td colspan=1>{{$cash}}</td>
             <td colspan=1>{{$cash/$total_liabilities}}</td>
        </tr>
      </table>
    </div>

    <div class="container-fluid" id="debtDiv">
      <h3>Current Ratio </h3>
      <table class="company_table" id="debtTable">
        <tr>
            <th>Total Assets</th>
            <th>Total Liabilities</th>
            <th>Current Ratio</th>
        </tr>
        <tr>
             <td colspan=1>{{$total_assets}}</td>
             <td colspan=1>{{$total_liabilities}}</td>
             <td colspan=1>{{$total_assets/$total_liabilities}}</td>
        </tr>
      </table>
    </div>
@endsection
