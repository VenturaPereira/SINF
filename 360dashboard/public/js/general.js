function toggle(ele,event){

  var arr = ele.split("-");
  var id = arr[0];
  var i_aux = arr[1];
  var x= document.getElementById(id).rows;
  var el_span = event.target;

  for(var i=i_aux; i < x.length-1; i++){
  if(x[i].style.display === ""){
    x[i].style.display = "none";
    el_span.innerHTML = "View more";
  } else {
    x[i].style.removeProperty('display');
    el_span.innerHTML = "View less";
  }
  }
}
