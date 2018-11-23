@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/roundGraphs.js') }}"></script>
    <div>

      <div class="container-fluid">
        <h3>Sales orders </h3>
        <table class="company_table">
    <tr>
      <th>#</th>
      <th>ID</th>
      <th>Product</th>
      <th>Quantity</th>
      <th>Client ID</th>
    </tr>
    <tr>
      <td>1</td>
      <td>101010</td>
      <td>Banana</td>
      <td>3</td>
      <td>1010</td>
    </tr>
    <tr>
      <td>1</td>
      <td>101010</td>
      <td>Banana</td>
      <td>3</td>
      <td>1010</td>
    </tr>
    <tr>
      <td>1</td>
      <td>101010</td>
      <td>Banana</td>
      <td>3</td>
      <td>1010</td>
    </tr>
  </table>
      </div>

      <div class="container-fluid">
        <h3>Stock </h3>
        <table class="company_table">
    <tr>
      <th>#</th>
      <th>Product</th>
      <th>Quantity</th>
    </tr>
    <tr>
      <td>1</td>
      <td>Banana</td>
      <td>3</td>
    </tr>
    <tr>
      <td>2</td>
      <td>Banana</td>
      <td>3</td>
    </tr>
    <tr>
      <td>1</td>
      <td>Banana</td>
      <td>3</td>
    </tr>
  </table>
      </div>


      <div class="roundGraph d-inline-flex m-5" id="roundChartContainerInventory-/postajaxRound" style="height: 300px; width: 50%;"> </div>
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
