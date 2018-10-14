<?php
require "../../helpers/settings.config.inc";
require "../../helpers/user.class.php";
require "../../helpers/job.class.php";
include "../templates/header.php";

if($me == "guest"){
    echo "Sorry. You should <a href='../login.php'> Or <a href='../signup.php' to complete the process.";
}
function error($msg = false){
if($msg == false){
    $msg = '<p class="error_msg">
     <span style="color: #953939;">&#9888; </span> Your request could not be completed
   </p>
   <p>
     This may occur if you are not logged in, the link you followed was changed or you do not have
     enough permissions to make the  request.
   </p>';
}
?>
<style type="text/css">
  .error_wrapper{
      background-color: #b8c5dc;
      padding: 10px;
      min-height: 5em;
      border: 1px solid #5171aa;
   }
   .error_msg{
       border-bottom: 1px solid #e7e7e7;
   }
</style>
<div class="error_wrapper">
   <?php echo $msg; ?>
</div>    
<?php 
}
if(!isset($_GET['id']) || ($_GET['id'] == "") || (ctype_digit($_GET['id']) == false)){
    error();
    exit();
}
if($me->utype == "emp"){
    error();
    exit();
}

 $id = $_GET['id'];
 if($me->apply($id) != "ok"){
    echo $me->apply($id);
 }
 else{
     header("location: {$_SERVER['HTTP_REFERER']}");
 }
