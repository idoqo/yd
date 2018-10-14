var Request = false;
if(window.XMLHttpRequest){
    Request = new XMLHttpRequest();
} else{
    Request = new ActiveXObject("Microsoft.XMLHTTP");
}

//Check emails if already exists
function checker(param){
    if(Request){
        Request.onreadystatechange = function(){
            if(Request.readyState == 4 && Request.status == 200){
                $('#p').empty();
                $('#p').append(Request.responseText);
            }
        };
        Request.open("GET", param, true);
        Request.send();
    }
}

/*This should actually be $(document).ready()...buh over s.a.b.b.i d worry*
DOM ready function code...
*/
r(function()
{
    /*Show and hide log box...*/
    function showBox(id){
        $('.overlay').css("display", "block");
        id.css({"z-index": 99999
            //"position": "relative"
        });
        id.fadeIn(1000);
        $('body').css("overflowY", "hidden");
        $('.close').click(function(){
            id.fadeOut(500);
            $('.overlay').css("display", "none");
            $('body').css("overflowY", "scroll");
        })
    }
    var logBtn = $("#xWsdg");
    var logBox = $("#login-box");
    logBtn.on("click", function(e){
        e.preventDefault();
        showBox(logBox);
    });
   
    /*SHOW MESSAGES*/
    //open div
    var msgContainer = $("#msg");
    var clickToChat = $("#msg-parent");

    clickToChat.on("click", function(){
        showBox(msgContainer);
    });


    //MESSAGES.PHP

});

/*Load the conversations with a particular user.*/

                              
function r(f){/in/.test(document.readyState) ? setTimeout('r('+f+')',5): f()}