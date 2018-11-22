@extends('layouts.app')

@section('content')
    <div>

    <div class="container-fluid">
      <h3>Top Suppliers </h3>
      <table class="company_table">
  <tr>
    <th>#</th>
    <th>First Name</th>
    <th>Client Number</th>
  </tr>
  <tr>
    <td>1</td>
    <td>Maria LDSA</td>
    <td>101010</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Maria LDSA</td>
    <td>101010</td>
  </tr>
  <tr>
    <td>3</td>
    <td>Maria LDSA</td>
    <td>101010</td>
  </tr>
</table>
    </div>


    <div class="container-fluid">
      <h3>Top Products </h3>
      <table class="company_table">
  <tr>
    <th>#</th>
    <th>Product Name</th>
    <th>Amount</th>
    <th>Client Id</th>
  </tr>
  <tr>
    <td>1</td>
    <td>Banana</td>
    <td>500</td>
    <td>101010</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Orange</td>
    <td>500</td>
    <td>101010</td>
  </tr>
  <tr>
    <td>3</td>
    <td>Banana</td>
    <td>500</td>
    <td>101010</td>
  </tr>
</table>
    </div>


<div>
  <h3 class="text-center">Supplies</h3>
    <div id="chartContainer" style="height: 300px; width: 50%;">
</div>

    </div>
@endsection

<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2",
	animationEnabled: true,


	data: [{
		type: "pie",
		indexLabelFontSize: 18,
		radius: 100,
		indexLabel: "{label} - {y}",
		yValueFormatString: "###0.0\"%\"",
		click: explodePie,
		dataPoints: [
			{ y: 42, label: "Gas" },
			{ y: 21, label: "Nuclear"},
			{ y: 24.5, label: "Renewable" },
			{ y: 9, label: "Coal" },
			{ y: 3.1, label: "Other Fuels" }
		]
	}]
});
chart.render();

function explodePie(e) {
	for(var i = 0; i < e.dataSeries.dataPoints.length; i++) {
		if(i !== e.dataPointIndex)
			e.dataSeries.dataPoints[i].exploded = false;
	}
}

}
</script>
