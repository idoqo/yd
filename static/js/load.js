$(document).ready(function(){
 checkURL();//function def
 $('.sidebar li a').click(function(e){//transverse thru all a elements
     checkURL(this.hash);//and give them new onclick event
 });
 setInterval("checkURL()", 250);
});

var lasturl = "";
function checkURL(hash){
    if(!hash)hash = window.location.hash;
    if(hash != lasturl){
        lasturl = hash;
        loadPage(hash);
    }
}

function loadPage(url){
    url = url.replace("#", "");
    
    $.ajax({
        type: "POST",
        url: "load.php",
        data: "page="+url,
        dataType: "html",
        success: function(msg){
            if(parseInt(msg) != 0){
                $('#main-body').html(msg);
            }
        }
        
    })
}