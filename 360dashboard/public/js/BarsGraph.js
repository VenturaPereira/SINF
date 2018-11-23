$(document).ready(function(){

  var id = document.getElementsByClassName("BarGraph")[0].id;
  var arr = id.split("-");
  var title = arr[1];
  var y_axis = arr[2];
  var y_axis2 = arr[3];
  var y_axis_le = arr[4];
  var y_axis2_le = arr[5];
  var y_axis_expl = arr[6];
  var y_axis2_expl = arr[7];
  var url = arr[8];
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            /* the route pointing to the post function */
            url: url,
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: CSRF_TOKEN, message:$(".getinfo").val()},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
              var d_a = jQuery.parseJSON (data);

              var chart = new CanvasJS.Chart(id, {
              	animationEnabled: true,
              	title:{
              		text: title
              	},
              	axisY: {
              		title: y_axis,
              		titleFontColor: "#4F81BC",
              		lineColor: "#4F81BC",
              		labelFontColor: "#4F81BC",
              		tickColor: "#4F81BC"
              	},
              	axisY2: {
              		title: y_axis2,
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
              		name: y_axis_expl,
              		legendText: y_axis_le,
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
                  name: y_axis2_expl,
              		legendText: y_axis2_le,
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
        });

});
