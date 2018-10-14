<?php
if((isset($_SESSION['error']))){
    if(isset($_SESSION['error'])){
        if($_SESSION['error'] =="none"){
            $_SESSION['message'] = "Your account has been created. Please login with the details you registered with";
            header("location: /internshub/pc/signin");
            unset($_SESSION['error']);
            exit;
        }
        else {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
    }
}
?>
<div class="reg-forms" id="company">
    <form action="/helpers/registrar.php" method="post" enctype="multipart/form-data">
        <p style="margin-left: 2em">Already a member? <a href="signin">Sign In</a></p>
        <p style="text-align: center; padding: 3px 0;">OR</p>
        <p class="ui-btn"><a href="signup/work">I want to work</a></p>
        <p><input type="text" placeholder="Company Name" name="compName" class="first"></p>
        <p><input type="text" placeholder="E-Mail" name="email"></p>
        <p><input type="text" placeholder="Corporate Address" name="location"></p>
        <p><input type="text" placeholder="Tel (Optional)" name="tel"></p>
        <p><input type="password" placeholder="Password" name="password"></p>
        <input type="hidden" name="utype" value="emp">
        <p style="font-size: .8em;">By Signing Up, you agree to our <a href="">Terms of Service</a></p>
        <input type="submit" name="register" value="Sign Up">
    </form>
</div>