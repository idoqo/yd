<?php
if(isset($_POST['save'])){
    $_POST['overview'] = htmlspecialchars($_POST['overview']);
    $_POST['location'] = htmlspecialchars($_POST['location']);

    if(!isValidName($_POST['fname']) || trim($_POST['lname']) == ""){
        $_SESSION['error'] = "New first name is invalid";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if(!isValidName($_POST['lname']) || trim($_POST['lname']) == ""){
        $_SESSION['error'] = "New last name is invalid";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION['error'] = "New e-mail is invalid";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if(!isPhoneNumber($_POST['tel'])){
        $_SESSION['error'] = "New phone number is invalid";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if(strlen($_POST['overview']) > 1000){
        $_SESSION['error'] = "Overview cannot be more than 1000 words";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    if(($_POST['email'] != $me->email) && (User::checker($_POST['email'] !== 0))){
        $_SESSION['error'] = "The email you entered is already registered";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }

    if($_FILES['photo']['name'] !== ""){
        $changePhoto = $me->changeDP($_FILES['photo'], "../images/profiles/");
        if($changePhoto !== "ok"){
            $_SESSION['error'] =$changePhoto;
            header("location: ".$_SERVER['REQUEST_URI']);
            exit;
        }
        else{
            if($_POST['email'] != $me->email){
                setcookie('logged', $_POST['email'], time()+3400);
            }
            foreach($_POST as $p => $q){
                if($p == "save"){
                    continue;
                }
                $me->updateField($p, $q);
            }
            header("location: dashboard");
        }
    }
    else{
        //update the new cookie value
        if($_POST['email'] != $me->email){
            setcookie('logged', $_POST['email'], time()+3400);
        }
        foreach($_POST as $p => $q){
            if($p == "save"){
                continue;
            }
            $me->updateField($p, $q);
        }
        header("location: dashboard");
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
                <img src="../images/profiles/<?php echo $me->displayPic; ?>" width="120" height="120">
                <div class="yd-fileChooser">
                    <label for="photo">
                        <span class="fa fa-camera"></span>
                        <input type="file" name="photo" id="photo" accept="image/*"/>
                        <input disabled type="text" value="Change" title="Change Photo">
                    </label>
                </div>
            </div>
            <div class="col-3">
                <label for="overview">
                    <textarea name="overview" id="overview" style="width: 100%; height: 120px;padding: 10px;">
                        <?php echo ($me->overview == "") ? "Overview" : $me->overview ?>
                    </textarea>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <div class="input-container">
                    <label for="fname">
                        <input type="text" name="fname" value="<?php echo $me->fname; ?>">
                    </label>
                </div>
                <div class="input-container">
                    <label for="lname">
                        <input type="text" name="lname" value="<?php echo $me->lname; ?>">
                    </label>
                </div>
                <div class="input-container">
                    <label for="email">
                        <input type="text" name="email" value="<?php echo $me->email; ?>">
                    </label>
                </div>
                <div class="input-container">
                    <label for="tel">
                        <input type="text" name="tel" value="<?php echo ($me->tel == "") ? "Telephone": $me->tel; ?>">
                    </label>
                </div>
                <div class="input-container">
                    <label for="location">
                        <input type="text" name="location" value="<?php echo ($me->location == "") ? "Telephone": $me->location; ?>">
                    </label>
                </div>
            </div>
        </div>
        <input type="submit" name="save" value="Save">
    </form>
</div>