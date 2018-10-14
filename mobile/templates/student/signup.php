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
<div class="reg-forms" id="individual">
    <form action="/helpers/registrar.php" method="post">
        <p style="margin-left: 2em">Already a member? <a href="signin">Sign In</a></p>
        <p style="text-align: center; padding: 3px 0;">OR</p>
        <p class="ui-btn"><a href="?controller=employer&action=signup">I want to Hire</a></p>
        <p><input type="text" placeholder="First Name" name="fname"></p>
        <p><input type="text" placeholder="Last Name" name="lname"></p>
        <p><input type="text" placeholder="E-Mail" name="email"></p>
        <p>
            <label for="location">
                <select name="location">
                    <option value="">Location</option>
                    <?php
                    $fp = file("../core/locations.txt");
                    foreach($fp as $line){
                        ?>
                        <option value="<?=$line;?>"><?=$line;?></option>
                        <?php
                    }
                    ?>
                </select>
            </label>
        </p>
        <p><input type="text" placeholder="Tel (Optional)" name="tel"></p>
        <p><input type="password" placeholder="Password" name="password"></p>
        <input type="hidden" name="utype" value="student">
        <p style="font-size: .8em;">By Signing Up, you agree to our <a href="">Terms of Service</a></p>
        <input type="submit" name="register" value="Sign Up">
    </form>
</div>