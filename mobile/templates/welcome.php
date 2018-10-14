<?php
require_once "../../helpers/settings.config.inc";
require_once "../../helpers/functions.php";
require_once "../../helpers/user.class.php";
$pageTitle = "Settings";
include "header.php";
if($me == "guest"){
    header("location: /internshub/mobile/signin");
    exit();
}
$conn = new PDO(DB_DSN, DB_USER, DB_PASS);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<script type="text/javascript">
    function loadSubCats(str){
        if(window.XMLHttpRequest){
            var Request = new XMLHttpRequest();
        }else{
            Request = new ActiveXObject("Microsoft.XMLHTTP");
        }
        if(Request){
            $('.skill_sets').empty().prepend("<img src='/internshub/images/resources/294.gif' />");
            Request.onreadystatechange = function(){
                if(Request.readyState == 4 && Request.status == 200){
                    $('.skill_sets').empty().append(Request.responseText);
                }
            };
            Request.open("GET", "/internshub/mobile/core/server.php?category="+str, true);
            Request.send();
        }
    }
</script>
    <style type="text/css">
  .fileUpload{
      position: relative;
      overflow: hidden;
      margin: 10px;
  }
  .fileUpload span{
      background: #2573A6;
      padding:0.5em 0.6em;
      color: white;
      border-radius: 10px 10px 0px 0px;
  }
  .fileUpload span i{
      color: white;
      padding-right: 0.5em;
      padding-top: 0.8em;
  }
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    cursor: pointer;
    opacity: 0;
    border: 0;
}
  .ui-btn{
      padding: .4em 1em;
      background: #42B28C;
      border-radius: 2px;
      border: none;
      color: white;
      margin-top: 1.4em;
  }
#_skills form input[type="text"]{
    background-color: white;
    position: relative;
    margin: 3px 0;
    width: 100%;
}
.step3 p a, .step3 p i{
    background: #44a087;  
    color: white;
    padding: .8em;
    padding-right: .4em;
    border-radius: 5px;
}
.skill-list{
    list-style: none;
}
.skill-list li{
    display: block;
    margin: 1em;
    background: #e5eaee;
    padding: 5px;
    border: 1px solid #d7d7d7;
}
.skill-list li input[type="checkbox"]{
    margin-right: 5px;
}
textarea{
    width: 90%;
    height: 8em;
}
</style>
<?php 
$option = isset($_GET['option']) ? $_GET['option'] : "photo";
switch($option)
{
    case "photo":
?>
<script>
$(document).ready(function(){
 document.getElementById("uploadBtn").onchange = function () {
    document.getElementById("uploadFile").value = this.value;
};
})
</script>
<?php
    if(isset($_POST['save'])){
        $img = $_FILES['pic'];
            if($me->changeDP($_FILES['pic'], "../../images/profiles/", "../../images/thumbnails/") === "ok") {
                header("location: skills");
                exit();
            }
            else{
                var_dump($me->changeDP($_FILES['pic'], "../../images/profiles/", "../../images/thumbnails/"));
            }
    }
?>
    <h3>Let's get started....</h3>
    <div class="tool_tip">
       <p>Choose a display Picture</p>
    </div>
    <div>
    <img src="../images/profiles/<?php echo $me->displayPic;?>" width="140" height="140" style="margin-top: 1em;">
    </div>
    <form action="welcome/photo" method="post" enctype="multipart/form-data">
    <div class="fileUpload">
       <span><i class="icon-folder-open"></i>Browse</span>
        <input type="file" name="pic" class="upload" id="uploadBtn">
        <input value="Choose File" disabled="disabled" id="uploadFile" style="border-radius: 4px;"; size="60">  
    </div>
       <a href="welcome/skills" class="ui-btn passive">Skip</a>
       <button class="ui-btn" type="submit" name="save">Next</button>
    </form>
<?php
    break;
    
    case  "skills":
//After user submits from select...
    if(isset($_POST['set_skills'])){
        $cat = $_POST['skill_cat'];
        $skillArray = $_POST['skill'];
        //var_dump($me->setSkills($skillArray));
        foreach($skillArray as $r){
            if($me->setSkill($r) !== true){
                echo "Sorry. Your skills could not be updated. Please try later";
                break;
            }
        }
        header("location: overview");
    }
        ?>
    <div id="_skills">
        <p>Add your Expertise</p>
        <form action="welcome/skills" method="post">
            <label for="category">
                <select name="skill_cat" onchange="loadSubCats($(this).val())">
                    <option value="">Select a category</option>
                    <?php
                    $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
                    $sql = "SELECT DISTINCT skill_category FROM skills";
                    $st = $conn->prepare($sql);
                    try{
                        $st->execute();
                        $cats = array();
                        while($rs = $st->fetch(PDO::FETCH_ASSOC)){
                            $cat = $rs['skill_category'];
                            echo "<option value='$cat'>$cat</option>"; #echo the fetched categories as option values
                        }
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                    }
                    ?>
                </select>
                <div class="skill_sets"></div>
            </label>
            <a class="ui-btn passive" href="overview">Skip</a>
            <button class="ui-btn" type="submit" name="set_skills">Next</button>
        </form>
        <div>
            <p class="section-title">Current skills</p>
            <div>
            <?php
                $skills = $me->getSkills();
                if(!empty($skills) && $skills !== false) {
                $skillCount = array_shift($skills);
                foreach ($skills as $skill) {
                    echo "<p>$skill <span style='float: right;'><a href='#' style='text-decoration: underline;'>Remove</a></span></p>";
                }
        }
            ?>
            </div>
        </div>
    </div>
    <?php 
    break;

    case "done":
        echo "<div class='feed-element'>";
            echo "Your profile is set. <br /><br />";
            echo "<span class='ui-btn'><a href='dashboard'>Go to your dashboard</a></span>";
            echo "<br /> to start viewing listings";
        echo "</div>";
}