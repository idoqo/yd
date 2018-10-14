function loadPage(url){
 $.ajax({
  type: "POST",
  url: "core/server.php",
  data: "rt="+url,
  dataType: "html",
  
  success: function(msg){
   $('.overlay').css("display","none");
   $('#loader').css("display", "none");
   if(parseInt(msg) != 0)
    $('#bigger-box').empty().append(msg); 
  },
  
  beforeSend: function(){
   $('.overlay').css("display", "block");
   $('body').css("overflow-x", "hidden");
   $('#loader').css("display", "block");
  }
 });
}

$(document).ready(function(){
 $('#sidebar a').click(function(e){
  e.preventDefault();
  $('.current').removeClass("current");
  $(this).parent().addClass("current");
  url = this.hash.replace("#", "");
  loadPage(url);

 })
})