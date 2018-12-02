@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/BarsGraph.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/BarsGraphFinance.js') }}"></script>
<link href="{{ URL::asset('css/financial.css') }}" rel="stylesheet">

    <div class="text-center">

        <div class="BarGraph" id="BarChartContainer-Income Vs Expenses (2017)-Thousands-Thousands-Income-Expenses-Income (thousand)-Expenses (thousand)-postajax" style="height: 370px; width: 100%;"></div>

        <div class="BarGraphFinance" id="BarChartFinanceContainer-Accounts receivable Vs Accounts payable (2017)-Thousands-Thousands-Accounts receivable-Accounts payable-Accounts receivable (thousand)-Accounts payable (thousand)-postajax" style="height: 370px; width: 100%;"></div>
    </div>

    <div class="container-fluid" id="debtDiv">
      <h3>Debt-To-Equity </h3>
      <table class="company_table" id="debtTable">
        <tr>
            <th>Debt</th>
            <th>Equity</th>
            <th>Debt to Equity</th>
        </tr>
        <tr>
             <td colspan=1>10 milhões</td>
             <td colspan=1>30 milhões</td>
             <td colspan=1>33,3%</td>
        </tr>
      </table>
    </div>

    <div class="container-fluid" id="invDiv">

      <h3>Costs and Inventory </h3>
      <table class="company_table" id="invTable">
        <tr>
          <th>Cost of goods sold</th>
          <th>Average Inventory</th>
          <th>Inventory turnover</th>
        </tr>
        <tr>
             <td colspan=1>40 milhões</td>
             <td colspan=1>15 milhões</td>
             <td colspan=1>2.67</td>
        </tr>
      </table>
    </div>


@endsection

<!--<div class="well">
        <h2>Assets</h2>
        <h3>Current Assets</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Account</th>
                    <th>Balance in <%= financial_year.stop %></th>
                    <th>Balance in <%= previous_financial_year.stop %></th>
                    <th>Difference</th>
                </tr>
            </thead>
            <tbody>
                <% current_assets.forEach(function (account) { %>
                <tr>
                    <td><%= account.number %> <%= account.name %></td>
                    <td><%= account.balance.toFixed(2) %></td>
                    <td><%= account.previous_balance.toFixed(2) %></td>
                    <td><%= account.difference.toFixed(2) %></td>
                </tr>
                <% }) %>
                <tr>
                    <td></td>
                    <td>&Sigma; = <%= total_current_assets.toFixed(2) %></td>
                    <td>&Sigma; = <%= previous_total_current_assets.toFixed(2) %></td>
                    <td><%= (total_current_assets - previous_total_current_assets).toFixed(2) %></td>
                </tr>
            </tbody>
        </table>

        <h3>Non-Current Assets</h3>
        <p>There is no non-current assets for this financial year.</p>

        <h3>Total Assets</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Balance in <%= financial_year.stop %></th>
                    <th>Balance in <%= previous_financial_year.stop %></th>
                    <th>Difference</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><%= total_current_assets.toFixed(2) %></td>
                    <td><%= previous_total_current_assets.toFixed(2) %></td>
                    <td><%= (total_current_assets - previous_total_current_assets).toFixed(2) %></td>
                </tr>
            </tbody>
        </table>
    </div>-->
