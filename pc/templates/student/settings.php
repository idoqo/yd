<?php
$section = isset($_GET['section']) ? $_GET['section'] : "";
if($section != ""){
    $path = "templates/student_mode/editor/";
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
<style type="text/css">
    .input-container input[type="text"], .form-holder input[type="password"] {
        width: 80%;
        padding: .8em 4em;
        background-color: #fff;
        color: #505152;
        border: 0;
        border-radius: 3px;
    }
    form select{
        padding: 10px;
    }
    form > *{
        margin: 1em 0;
    }
</style>
