<?php
include "../../helpers/settings.config.inc";
include "../../helpers/functions.php";
include "../../helpers/user.class.php";
$pageTitle = "Yedoe Feedback";

if(isset($_POST['send']) && $_POST['send'] == "Send"){
    var_dump($_POST);
    if(trim($_POST['name']) == ""){
        if($me == "guest") {
            $_SESSION['error'] = "Please provide your name";
            header("location: ".$_SERVER['REQUEST_URI']);
            exit;
        }else{
            $name = $me->fullName;
        }
    }
    if(trim($_POST['email']) == ""){
        if($me == "guest") {
            $_SESSION['error'] = "Please provide your email";
            header("location: ".$_SERVER['REQUEST_URI']);
            exit;
        }else{
            $name = $me->email;
        }
    }
    else{
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $_SESSION['error'] = "E-mail seems to be invalid";
            header("location: ".$_SERVER['REQUEST_URI']);
            exit;
        }
    }
    if(strlen($_POST['message']) > 1000){
        $_SESSION['error'] = "Message should be less than or equal to 1000 words";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    $to = "feedback@yedoe.com";
    $from = $email;
    $subject = isset($__subject) ? $__subject : "Feedback";
    $header = "From: ".$from;
    $message = $_POST['message'];
    if(mail($to, $subject, $message, $header)){
        $_SESSION['success'] = "Thanks for reaching out to us. Regards from the Yedoe Team!";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
    else{
        $_SESSION['error']="Your message could not be sent.";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }
}
?>
<div class="col-4 centered">
    <form action="<?=htmlspecialchars($_SERVER['REQUEST_URI'])?>" method="post" enctype="multipart/form-data" class="col-4 centered">
        <?php
        if(isset($_SESSION['error'])){
            echo "<div class='error col-6'>{$_SESSION['error']}</div><br/><br/>";
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
            echo "<div class='success'>{$_SESSION['success']}</div><br/>";
            unset($_SESSION['success']);
            echo "<p><a href='/'>Go Back Home</a></p>";
        }
        ?>
        <label for="name">
            <input type="text" name="name" placeholder="Full Name">
        </label>
        <label>
            <input type="text" name="email" placeholder="E-Mail">
        </label>
        <label>
            <textarea name="message" placeholder="Type your Message here"></textarea>
        </label>
        <button type="submit" class="button" name="send" value="Send">Send</button>
    </form>
</div>
<style type="text/css">
    form.col-4 input[type="text"], textarea{
        width: 100%;
        display : block;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #c8c8c8;
    }
    textarea{
        height: 10em;
    }
</style>