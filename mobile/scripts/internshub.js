var Request = false;
    if(window.XMLHttpRequest){
        Request = new XMLHttpRequest();
    }else{
        Request = new ActiveXObject("Microsoft.XMLHTTP");
    }


$(document).ready(function(){
/*...menu icon controller*/
$('#menu-launcher').on("click", function(e){
    e.preventDefault();
    $('.menu_list').slideToggle(300);
});

var clickToLog = $("#click_to_log");
var clickToReg = $("#click_to_reg");
var clickToCreate = $("#click_to_create");
clickToLog.click(function(){
   $("#logo").fadeToggle(500);
   $("#login-box").slideToggle(500);
});
clickToReg.click(function(){
  $("#signup-box-intern").slideToggle(500);
});
clickToCreate.click(function(){
  $("#signup-box-employer").slideToggle(500);
});


});
