<?php
session_start();
ob_start();
require_once "lib/settings.config.inc";
require_once "lib/lib.php";
require_once "lib/users.class.php";
require_once "lib/jobs.class.php";
$pageTitle = "Post a Job";
include "lib/head.inc";
require_once "templates/intern_profile.php";
$conn = new PDO(DB_DSN, DB_USER, DB_PASS);

if(!isset($_COOKIE['logged'])){
    $_SESSION['message'] = "Sorry, but you have to be logged in.";
    header("location: login.php");
    exit();
}
$email = $_COOKIE['logged'];
$pswrd = $_COOKIE['_intseid'];
$ID = User::getCurrentUser($_COOKIE['logged']);
$info = User::about($email, $pswrd);

if($info['utype'] == "intern"){
    echo "Unforunately, You cannot post a job. You may consider inviting specific users to your project";
    exit();
}
if(isset($_POST['post'])){
$job = new job();
$job->storeFormValues($_POST);
$job->posted_by = $ID['UserID'];
//verify url
if($_POST['app_method'] == "link"){
    if(($_POST['url'] != "") && (filter_var($_POST['url'], FILTER_VALIDATE_URL) == false)){
        echo "Invalid URL provided";
    }
}
$returnedID = $job->create();
$_SESSION['success'] = "<h3 style=\"padding: 0.9em; background: white; color: #589566;\"><i class=\"fa fa-check\"></i> Project Successfully added</h3>";
header("location: viewJob.php?id=$returnedID");
exit();
}
?>

<script type="text/javascript">
  function showSkills(str){
      var Request = false;
      if(str == ""){
          document.getElementById("skills").innerHTML = "";
      }else{
          if(window.XMLHttpRequest){
              Request = new XMLHttpRequest();
          }else{
              Request = new ActiveXObject("Microsoft.XMLHTTP");
          }
          Request.onreadystatechange = function(){
              if(Request.readyState == 4 && Request.status == 200){
                  document.getElementById("skills").innerHTML = Request.responseText;
              }
          }
          Request.open("GET", "getskills.php?cat="+str, true);
          Request.send();
      }

  }
  $('#url').css("display", "none");
</script>
<style type="text/css">

</style>
<p>Confused? <a href="#">View a Sample Job.</a> </p>
<form action="addproject" method="post" data-ajax="false">
<label for="title">Title: </label>
 <input type="text" name="title">
 <label for="category">Description: </label>
 <textarea cols="6" rows="3" name="description">

 </textarea>
 <label for="category">Category: </label>
 <select name="category" id="category" onchange="showSkills(this.value);" data-theme="d" data-native-menu="false">
   <option value="">Choose a Category</option>
   <?php
     $cats = $conn->query("SELECT DISTINCT skill_category FROM skills");
     while($r = $cats->fetch(PDO::FETCH_ASSOC)){
          foreach($r as $x){
              echo "<option value=\"$x\">".$x."<br></option>";
          }
     }

?>
 </select>
 <label for="skills">Skills Required: </label>
 <select name="skills[]" id="skills"  multiple="multiple" data-theme="d">

 </select>
  <label for="category">Responsiblities </label>
 <textarea cols="6" rows="3" name="responsibilities">

 </textarea>
 <label for="category">Requirements: </label>
 <textarea cols="6" rows="3" name="requirements">

 </textarea>
 <label for="fee">Fee (In Cedis): </label>
 <input type="number" name="fee">
 <label for="fee">How to Apply: </label>
 <select name="app_method" id="app_method" onchange="s();"  data-theme="d" data-native-menu="false">
 <option value="contact">Use My Contact</option>
 <option value="message">Direct Message</option>
 <option value="link">Apply via Website</option>
 </select>
 <input type="text" name="url" placeholder="URL" id="url">
 <button type="submit" name="post" value="post" class="submit">Post</button>
</form>
<script type="text/javascript">
function s(){
   var value = $("#app_method").val();  
   if(value == "link"){
       $('#url').css("display", "block");
   }
  }
</script>