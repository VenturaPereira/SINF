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
              			{ label: "January", y: 266.21 },
              			{ label: "February", y: 302.25 },
              			{ label: "March", y: 157.20 },
              			{ label: "April", y: 148.77 },
              			{ label: "May", y: 101.50 },
              			{ label: "June", y: 97.8 },
                    { label: "July", y: 266.21 },
              			{ label: "August", y: 302.25 },
              			{ label: "September", y: 157.20 },
              			{ label: "October", y: 148.77 },
              			{ label: "November", y: 101.50 },
              			{ label: "December", y: 97.8 }
              		]
              	},
              	{
              		type: "column",
                  name: y_axis2_expl,
              		legendText: y_axis2_le,
              		axisYType: "secondary",
              		showInLegend: true,
              		dataPoints:[
                    { label: "January", y: 10.46 },
              			{ label: "February", y: 2.27 },
              			{ label: "March", y: 3.99 },
              			{ label: "April", y: 4.45 },
              			{ label: "May", y: 2.92 },
              			{ label: "June", y: 3.1 },
                    { label: "July", y: 15.6 },
              			{ label: "August", y: 1.2 },
              			{ label: "September", y: 2.5 },
              			{ label: "October", y: 8.9 },
              			{ label: "November", y: 8.8 },
              			{ label: "December", y: 5.5 }
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
