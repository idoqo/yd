<div id="wrapper">
    <p>
        Login
    </p>
    <?php
    if(isset($_SESSION['error'])){
        echo "<div class='error-msg'>";
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        echo "</div>";
    }
    if(isset($_SESSION['message'])){
        echo "<div class='col-4 centered feedback success'>{$_SESSION['message']}</div>";
        unset($_SESSION['message']);
    }
    ?>
    <div class="form-holder">
        <p style="color: #818181;">Not yet a member? <a href="?controller=student&action=signup">Register </a> now!</p>
        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
            <div class='error-msg'>
                <?php if(!empty($err)){echo $err[0];} ?>
            </div>
            <div class="input-container">
                <span class="fa fa-at"></span>
                <input type="text" name="email" id="eemail" placeholder="E-Mail">
            </div>
            <div class="input-container">
                <span class="fa fa-key"></span>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <br />
            <p class="form-subscript"><a href="#">Forgot Password?</a></p>
            <input type="submit" name="login" value="Login" id="login">
            <br /><br /><br />
        </form>
    </div>
</div>
