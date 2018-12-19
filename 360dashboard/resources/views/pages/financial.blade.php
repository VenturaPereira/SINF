@extends('layouts.app')

@section('content')

<link href="{{ URL::asset('css/financial.css') }}" rel="stylesheet">

    <div class="text-center">
      <div class="BarGraph" id="inc_exp" >
        // With Lava class alias
        {!! \Lava::render('ColumnChart', 'Finances', 'inc_exp') !!}
      </div>
    </div>

    <div class="near_by_hotel_wrapper">
      <div class="near_by_hotel_container">
        <table class="table no-border custom_table dataTable no-footer dtr-inline">
          <colgroup>
          <col width="40%">
          <col width="20%">
          <col width="">
          </colgroup>
          <thead>
            <tr>
              <th>CATEGORY</th>
              <th class="text-center">SUB CATEGORY</th>
              <th class="text-center">VALUE</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>CASH</td>
              <td class="text-center">1</td>
              <td class="text-center">{{round($cash,1)}}</td>
            </tr>
            <tr>
              <td>CASH RATIO</td>
              <td class="text-center">1</td>
              <td class="text-center">{{round( ($cash/$total_liabilities), 2)}}</td>
            </tr>
            <tr>
              <td>TOTAL ASSETS</td>
              <td class="text-center">1</td>
              <td class="text-center">{{round($total_assets,1)}}</td>
            </tr>
            <tr>
              <td>TOTAL LIABILITIES</td>
              <td class="text-center">1</td>
              <td class="text-center">{{round($total_liabilities, 1)}}</td>
            </tr>
          </tr>
          <tr>
            <td>CURRENT RATIO</td>
            <td class="text-center">1</td>
            <td class="text-center">{{round( ($total_assets/$total_liabilities), 2)}}</td>
          </tr>
          </tbody>
        </table>
      </div>
      </div>
    
@endsection
