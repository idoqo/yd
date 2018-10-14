<div id="wrapper">
    <p>
        <a href="?controller=student&amp;action=signup" class="utype-toggle" id="current">I want to Work</a>
        <a href="?controller=employer&amp;action=signup" class="utype-toggle">I want to Hire</a>
    </p>
    <div class="form-holder">
        <p style="color: #818181;">Already a member? <a href="?controller=user&amp;action=signin">Login </a></p>
        <div class="error-msg">
            <?php
            if(isset($_SESSION['error'])){
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            }
            ?>
        </div>
<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
    <div class="input-container">
        <span class="required">*</span>
        <span class="fa fa-user"></span>
        <input type="text" name="fname" placeholder="First Name">
    </div>
    <div class="input-container">
        <span class="required">*</span>
        <span class="fa fa-user"></span>
        <input type="text" name="lname" placeholder="Last Name">
    </div>
    <div class="input-container">
        <span class="required">*</span>
        <span class="fa fa-at"></span>
        <input type="text" name="email" id="email" placeholder="E-Mail">
    </div>
    <p id="p"></p>
    <div class="input-container">
        <span class="required">*</span>
        <span class="fa fa-map-marker"></span>
        <input type="text" name="location" placeholder="Location">
    </div>
    <div class="input-container">
        <span class="required">*</span>
        <span class="fa fa-lock"></span>
        <input type="password" name="password" placeholder="Password">
    </div>
    <input name="utype" type="hidden" value="student">
    <input type="submit" name="register" value="Sign Up">
    <br />
    <br />
    <br />
</form>
    </div>
    <p style="font-size: .8em;">Fields marked <span style="color: #da534f;">*</span>  must be filled.</p>
    <p class="form-subscript">
        <span>By signing up, you agree to our <a href="#">Terms of service</a> and <a href=""> privacy policy</a></span>
    </p>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        var portion = $('#p'),
            emField = $('#email');
        $(emField).keyup(function(){

        })
    })
</script>