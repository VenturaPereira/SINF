/*$(document).ready(function(){

  var id = document.getElementsByClassName("graph")[0].id;
  var arr = id.split("-");
  var title = arr[1];
  var y_axis = arr[2];
  var url = arr[3];    

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            /* the route pointing to the post function */
        /*    url: url,
     /*       type: 'POST',
            /* send the csrf-token and the input to the controller */
        /*    data: {_token: CSRF_TOKEN, message:$(".getinfo").val()},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
      /*      success: function (data) {
              var d_a = jQuery.parseJSON (data);
              var chart = new CanvasJS.Chart(id, {
                title: {
                  text: title
                },
                axisY: {
                  title: y_axis
                },
                data: [{
                  type: "line",
                  dataPoints: d_a
                }]
              });
              chart.render();
            }
        });

});*/
