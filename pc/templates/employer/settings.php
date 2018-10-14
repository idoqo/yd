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
        $_SESSION['error'] = "The email you entered is already registered";
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
            $_SESSION['error'] = "Unable to complete request. Some changes were not saved";
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
<style type="text/css">
h1{
    border-bottom: 2px solid #e0e0e0;
}
td h3{
    font-weight: normal;
    margin-bottom: 1em;
}
table{
    width: 90%;
}
table *{
    font-size: .98em;
}
table a{
    color: #1382b6;
}
</style>
<h1>Settings</h1>
<?php
if(isset($_SESSION['error'])){
    echo "<div class='error'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']);
}
?>
<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
    <div class="col-5">
        <div class="yd-fileChooser">
            <img src="../images/profiles/<?php echo $me->displayPic; ?>" height="200" width="200"/>
            <label>
                <input type="file" name="photo" accept="image/*"/>
                <span style="position:absolute; top: 50%; right: 78%; font-weight: bold; color: #fff; background: rgba(0,0,0,0.34); padding: 8px 12px;">
                     <i class="fa fa-camera"></i>
                    Change Photo
                </span>
            </label>
        </div>
    </div>
    <div class="col-5">
    <table cellspacing="5">
        <tr>
            <td><h4>Company Profile</h4></td>
        </tr>
        <tr>
            <td><p>Name</p></td>
            <td>
                <label>
                    <input type="text" name="compName" value="<?php echo $me->fullName; ?>" />
                </label>
            </td>
        </tr>
        <tr>
            <td><p>E-Mail</p></td>
            <td>
                <label>
                    <input type="email" name="email" value="<?php echo $me->email; ?>"/>
                </label>
        </tr>
        <tr>
            <td><p>Website</p></td>
            <td>
                <label>
                    <input type="text" name="website" placeholder="http://www.example.com" value="<?php echo $me->website; ?>"/>
                </label>
            </td>
        </tr>
        <tr>
            <td><p>Location</p></td>
            <td>
                <label>
                    <input type="text" name="location" value="<?php echo $me->location; ?>" />
                </label>
        </tr>
        <tr>
            <td>
                <p>Industry</p>
            </td>
            <td>
                <label>
                    <select name="industry">
                        <option value="">Industry</option>
                        <?php
                        $cats = getSkills();
                        if(is_array($cats)){
                            foreach($cats as $cat){
                                echo "<option value={$cat['skill_id']}>{$cat['skill']}</option>";
                            }
                        }
                        ?>
                    </select>
                </label>
            </td>
        </tr>
        <tr style="height: .1em; width: 100%; background: #e0e0e0;"></tr>
    </table>
        <div class="overview-wrap">
            <p class="section-title mini">Company Overview</p>
            <label>
                <textarea name="overview" class="medium" placeholder="Company Overview"><?php echo $me->overview?></textarea>
            </label>
        </div>
        <div class="teaser-wrap">
            <p class="section-title mini">Why Work with us?</p>
            <label>
                <textarea name="teaser" class="medium" placeholder="Why Work with us?"><?php echo $info['teaser'] ?></textarea>
            </label>
        </div>
        <br />
        <div class="col-1">
        <input type="submit" name="save" value="Save" />
        </div>
    </div>
</form>