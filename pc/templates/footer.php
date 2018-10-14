<?php
/**close #bodycontainer opened in header.php and #globalcontainer**/
?>
</div>
</div>
<!--the empty .row div magically keeps the footer below page elements xD-->
<div class="row"></div>
<div class="row footer-wrap">
    <footer class="row col-5 centered" style="position:relative; bottom: 0;">
        <div class="col-1">
            <h3>Resources</h3>
            <a href="">Blog</a>
            <a href="">Job Scams</a>
        </div>
        <div class="col-1">
            <h3>Students</h3>
            <a href="">Browse openings</a>
            <a href="">Resume guide</a>
            <a href="">E-Mail Alerts</a>
        </div>
        <div class="col-1">
            <h3>Employers</h3>
            <a href="">E-Mail Alerts</a>
            <a href="">Getting it right</a>
            <a href="">Disclaimer</a>
        </div>
        <div class="col-2">
            <h3>Feedback</h3>
            <form action="" method="post">
                <label>
                    <input type="text" name="name" placeholder="Full Name" class="bum">
                </label>
                <label>
                    <input name="email" placeholder="E-Mail address" type="text" class="bum">
                </label>
                <textarea name="message" placeholder="Enter your message"></textarea>
                <button class="button" type="submit" name="send" value="Send">Send</button>
            </form>
        </div>
    </footer>

    <div class="row col-5 centered bottom-line">
        <p>
            <a href="#">Terms of Service</a>
            <a href="#">Disclaimer</a>
            <a href="#"><i class="fa fa-facebook"></i> Facebook</a>
            <a href="#"><i class="fa fa-twitter"></i> Twitter</a>
            <a href="#"><i class="fa fa-envelope"></i> help@yedoe.com</a>
        </p>
    </div>
</div>
<style type="text/css">
    form.col-4, input.bum, textarea{
        width: 100%;
        display : block;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #c8c8c8;
    }
    textarea{
        height: 4em;
    }
    footer h3{
        font-weight: normal;
        color: #eeeeee;
        margin-bottom: .9em;
    }
    footer a{
        display: block;
        color: #eeeeee;
    }
    .bottom-line p{
        border-top: 1px solid #eeeeee;
        padding: 15px 0;
    }
    .bottom-line a{
        display: inline-block;
        padding: 0 20px;
    }
<?php
if(isset($__styles)){
    echo $__styles;
}
if(isset($__scripts)){
    echo $__scripts;
}
?>
</style>
</body>
</html>