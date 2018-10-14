<?php
if(isset($_POST['login']) && $_POST['login'] == "Login"){
    $em = trim($_POST['email']);
    $pass = trim($_POST['password']);
    $err = array();
    if($em == ""){
        $_SESSION['error'] = "E-mail field cannot be empty";
        header("location: ".htmlspecialchars($_SERVER['REQUEST_URI']));
        exit();
    }
    if($pass == ""){
        $_SESSION['error'] = "Password field cannot be empty";
        header("location: ".htmlspecialchars($_SERVER['REQUEST_URI']));
        exit();
    }
    if(filter_var($em, FILTER_VALIDATE_EMAIL)== false){
        $_SESSION['error'] = "Email is invalid";
        header("location: ".htmlspecialchars($_SERVER['REQUEST_URI']));
        exit();
    }
    try {
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        $_SESSION['error'] = "Sorry, An error occurred. Please try later";
        header("location: ".$_SERVER['REQUEST_URI']);
        exit;
    }

    $sql = "SELECT UserID, email, password, utype, fname, lname, compName FROM userlist WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $em);
    if($stmt->execute()){
        $num = $stmt->rowCount();
        if($num < 1){
            $_SESSION['error'] = "E-Mail does not exist";
            header("location: ".htmlspecialchars($_SERVER['REQUEST_URI']));
            exit();
        }
        else{
            $details = $stmt->fetch();
            if(!(password_verify($pass,$details['password']))){
                $_SESSION['error'] = "Password and email did not match. Forgot it? Request a new one";
                header("location: ".htmlspecialchars($_SERVER['REQUEST_URI']));
                exit();
            }
            else {
                $me = new User($details);
                $me->logUser();
                $goto = isset($_SESSION['goto']) ? $_SESSION['goto'] : "dashboard";
                header("location: $goto");
                unset($_SESSION['goto']);
                exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, user-scalable=false">
<title>Yedoe Login</title>
<link href="../styles/css/font-awesome.min.css" rel="stylesheet">
<link href="../styles/entrance.css" rel="stylesheet">
</head>
<div>

</div>
<div class="wrapper">
<p style="text-align: center">Not yet a Member? <a href="signup" style="color: #42B28C;">Sign Up Now</a></p>
    <?php
    if(isset($_SESSION['error'])){
        echo "<div class='error-msg'>";
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        echo "</div>";
    }
    ?>
<p style="text-align: center; color: #3498DB; font-size: 4em;"><span class="icon-user"></span></p>
  <form action="" method="post">
     <input type="text" name="email" placeholder="Email" size="20">
     <input type="password" name="password" placeholder="Password" style="border-top: 1px solid #e7e7e7;border-bottom: 1px solid #fff;">
     <p><input type="submit" name="login" value="Login"></p>
  </form>
</div>
<style type="text/css">
    form{
        text-align: center;
        margin: auto;
        margin-top: 1em;
        border-radius: 3px;
        border:1px solid #fff;
        width: 90%;
    }
    form input[type="text"], form input[type="password"], form input[type="number"], form select{
        border:none;
        padding: 10px 1em;
        width: 90%;
        color: rgba(0, 0,0,0.6);
    }
    form input[type="text"], form input[type="password"]{
        border-bottom: 1px solid #fff;
    }
    form input[type="submit"]{
        width: 90%;
        border-radius: 3px;
        margin: 1em 0;
        padding: 10px;
        color: #fff;
        background: #42B28C;
        border: none;
    }
    .error-msg{
        color: #da534f;
    }
