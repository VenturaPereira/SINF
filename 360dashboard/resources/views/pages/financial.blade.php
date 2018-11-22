@extends('layouts.app')

@section('content')
    <div class="text-center">


        <div id="chartContainer" style="height: 370px; width: 100%;"></div>


        <div class="well">
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
            </div>
    </div>
@endsection


<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Crude Oil Reserves vs Production, 2016"
	},
	axisY: {
		title: "Thousands billed",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	axisY2: {
		title: "Thousand sold",
		titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
	},
	toolTip: {
		shared: true
	},
	legend: {
		cursor:"pointer",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Billed (thousand/month)",
		legendText: "Billed",
		showInLegend: true,
		dataPoints:[
			{ label: "Saudi", y: 266.21 },
			{ label: "Venezuela", y: 302.25 },
			{ label: "Iran", y: 157.20 },
			{ label: "Iraq", y: 148.77 },
			{ label: "Kuwait", y: 101.50 },
			{ label: "UAE", y: 97.8 }
		]
	},
	{
		type: "column",
		name: "Sales (thousand/month)",
		legendText: "Sales",
		axisYType: "secondary",
		showInLegend: true,
		dataPoints:[
			{ label: "Saudi", y: 10.46 },
			{ label: "Venezuela", y: 2.27 },
			{ label: "Iran", y: 3.99 },
			{ label: "Iraq", y: 4.45 },
			{ label: "Kuwait", y: 2.92 },
			{ label: "UAE", y: 3.1 }
		]
	}]
});
chart.render();

function toggleDataSeries(e) {
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else {
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>
