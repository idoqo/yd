<?php
if(isset($_POST['save'])){
    $ret = $_SERVER['REQUEST_URI'];

    if($_FILES['photo']['name'] != ""){
        $changePhoto = $me->changeDP($_FILES['photo'], "../images/profiles/");
        if($changePhoto != "ok"){
            $_SESSION['error'] = $changePhoto;
            header("location: $ret");
            exit;
        }
    }
    if(trim($_POST['compName']) == ""){
        $_SESSION['error'] = "Company Name cannot be blank";
        header("location: $ret");
        exit;
    }
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION['error'] = "New email is invalid";
        header("location: $ret");
        exit;
    }
    if((trim($_POST['website'] != "")) && (!filter_var($_POST['website'], FILTER_VALIDATE_URL))){
        $_SESSION['error'] = "Website seems to be invalid";
        header("location: $ret");
        exit;
    }
    if(($_POST['email'] != $me->email) && (User::checker($_POST['email'] !== 0))){
        $_SESSION['error'] = "Unable to complete request. Some changes were not saved";
        header("location: $ret");
        exit;
    }
    //update the new cookie value
    if($_POST['email'] != $me->email){
        setcookie('logged', $_POST['email'], time()+3400);
    }
    foreach($_POST as $p=>$q){
        //free those that has no space in your kingdom...
        if(($p == "save") || ($p == "teaser") || ($p == "industry")){
            continue;
        }
        if($me->updateField($p, $q) !== true){
            $_SESSION['error'] = "Unable to change email";
            header("location: $ret");
            exit;
        }
        else{
            //check for those in employer table
            if(($_POST['teaser'] != "")){
                $teaser = strip_tags($_POST['teaser']);
                if($me->updateEmpField("teaser", $teaser) !== true){
                    $me->updateEmpField("teaser", $teaser);
                }
            }
            if(($_POST['industry'] != "")){
                $teaser = strip_tags($_POST['industry']);
                if($me->updateEmpField("industry", $teaser) !== true){
                    $me->updateEmpField("industry", $teaser);
                }
            }
            header("location: profile");
        }
    }
}
?>
<div class="col-5">
    <?php
    if(isset($_SESSION['error'])){
        echo "<div class='error'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-1">
                <img src="../images/profiles/<?php echo htmlspecialchars($me->displayPic); ?>" width="120" height="120"><div class="yd-fileChooser">
                    <label for="photo">
                        <input type="file" name="photo" id="photo" accept="image/*"/>
                    </label>
                </div>
            </div>
            <div class="col-3">
                <label for="overview">
                    <textarea name="overview" id="overview" style="width: 100%; height: 120px;padding: 10px;">
                        <?php echo ($me->overview == "") ? "Overview" : htmlspecialchars($me->overview); ?>
                    </textarea>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <div class="input-container">
                    <label for="compName">
                        <input type="text" name="compName" value="<?php echo htmlspecialchars($me->compName); ?>">
                    </label>
                </div>
                <div class="input-container">
                    <label for="website">
                        <input type="text" name="website" value="<?php echo htmlspecialchars($me->website); ?>">
                    </label>
                </div>
                <div class="input-container">
                    <label for="email">
                        <input type="text" name="email" value="<?php echo htmlspecialchars($me->email); ?>">
                    </label>
                </div>
                <div class="input-container">
                    <label for="tel">
                        <input type="text" name="tel" value="<?php echo ($me->tel == "") ? "Telephone": htmlspecialchars($me->tel); ?>">
                    </label>
                </div>
                <div class="input-container">
                    <label for="location">
                        <input type="text" name="location" value="<?php echo ($me->location == "") ? "Location": htmlspecialchars($me->location); ?>">
                    </label>
                </div>
            </div>
        </div>
        <input type="submit" name="save" value="Save">
    </form>
</div>
<style type="text/css">
    form input[type="text"]{
        width: 100%;
        padding: .5em;
        margin-bottom: .3em;
    }
</style>