<?php
$section = isset($_GET['section']) ? $_GET['section'] : "";
if($section != ""){
    $path = "templates/student/editor/";
    $handle = opendir($path);
    while(false !== ($entry = readdir($handle))){
        if($entry == $section.".php"){
            $pathToFile = $path.$entry;
            include "$pathToFile";
            break;
        }
    }
}
else{
    ?>
    <div class="col-3 centered" style="height: 200px; background: #e7e7e7;text-align: center;">
        To edit your profile, choose a category from <a href="profile">Your Profile</a>.
    </div>
    <?php
}
?>