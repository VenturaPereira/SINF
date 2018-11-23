$(document).ready(function(){

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            /* the route pointing to the post function */
            url: '/postajax',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: CSRF_TOKEN, message:$(".getinfo").val()},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) {
              var d_a = jQuery.parseJSON (data);
              var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                  text: "Company growth"
                },
                axisY: {
                  title: "company value"
                },
                data: [{
                  type: "line",
                  dataPoints: d_a
                }]
              });
              chart.render();
            }
        });

});
