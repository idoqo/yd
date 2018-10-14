<?php
//duplicate of /core/registrar.php but this holds the email checker...
ob_start();
session_start();
require "../../helpers/settings.config.inc";
require "../../helpers/user.class.php";
require "../../helpers/functions.php";


/*if(isset($_POST['register']))
{
$type=isset($_POST['utype']) ? $_POST['utype'] : "";
if($type != "student" && $type != "employer"){
    $_SESSION['error'] = "We encountered an error during your registration. Please try later.";
    header("location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
if($type == "employer"){

    if(trim($_POST['compName']) == ""){
        $_SESSION['err_code'] = 1;
        $_SESSION['compName'] = $_POST['compName'];
        $_SESSION['error'] = "Please provide your company or individual name";
        header("location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    if(trim($_POST['email']) == "" || (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false)){
        $_SESSION['err_code'] = 2;
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['error'] = "The email you provided was invalid";
        header("location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    if(User::checker($_POST['email']) != 0){
        $_SESSION['error'] = "Sorry, a user already exists with the email you provided. Forgot your password? <a href='#'>Get a new one</a>";
        header("location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
    if(trim($_POST['location']) == ""){
        $_SESSION['error'] = "please enter your location/region";
        header("location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
    if(trim($_POST['tel']) != "" && isPhoneNumber($_POST['tel'] != true)){
        $_SESSION['err_code'] = 3;
        $_SESSION['tel'] = $_POST['tel'];
        $_SESSION['error'] = isPhoneNumber($_POST['tel']);
        header("location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    $x = new Employer($_POST);
    $x->utype = $type;
    /*$y = $x->create();
    if($y != true){throw new Exception($y);}*
    if(!$x->create()){
        //Log the next line and simply show an error message
        $_SESSION['error'] = "Oops! Something went wrong!";
    }
    else {
        $_SESSION['error'] = "none";
        $_SESSION['message'] = "Your account has been created. Please login with the details you registered with";
    }
    header("location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
elseif($type == "student"){
    if(isValidName($_POST['fname']) != "ok"){
        $_SESSION['err_code'] = 5;
        $_SESSION['fname'] = $_POST['fname'];
        $_SESSION['error'] = isValidName($_POST['fname']);
        header("location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    if(isValidName($_POST['lname']) != "ok"){
        $_SESSION['err_code'] = 6;
        $_SESSION['lname'] = $_POST['lname'];
        $_SESSION['error'] = isValidName($_POST['lname']);
        header("location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    if(trim($_POST['email']) == "" || (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false)){
        $_SESSION['err_code'] = 7;
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['error'] = "Invalid email provided";
        header("location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    if(User::checker($_POST['email']) != 0){
        $_SESSION['error'] = "Sorry, a user already exists with the email you provided. Forgot your password? <a href='#'>Get a new one</a>";
        header("location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    if(trim($_POST['tel']) != "" && isPhoneNumber($_POST['tel'] != true)){
        $_SESSION['err_code'] = 8;
        $_SESSION['tel'] = $_POST['tel'];
        $_SESSION['error'] = isPhoneNumber($_POST['tel']);
        header("location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
    $x = new Student($_POST);
    $x->utype = $type;
    if(!$x->create()){
        $_SESSION['error'] = "Ooops! Something went wrong!";
    }
    else{
        $_SESSION['error'] = "none";
        $_SESSION['message'] = "Your account has been created. Please login with the details you registered with";
        header("location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
    header("location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
else{
     //we don't know you sucker...
     $_SESSION['error'] = "Ooops! This is embarrassing. Something went terribly wrong during your registration.";
     header("location: {$_SERVER['HTTP_REFERER']}");
     exit();
 }
}
*/