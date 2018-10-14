<?php
$pageTitle = "Interns Hub";
require "../helpers/settings.config.inc";
require "../helpers/user.class.php";
include_once "templates/header.php";

if($me != "guest"){
    header("location: dashboard");
}

function mainIndex()
{
    ?>
    <div
        style="padding: .5em; text-align: justify; margin: auto;color: #fff; padding-bottom: 20px; min-height: 250px;font-size: 1.2em;">
        Lorem ipsum dolor sit amet, consectetur adipiscing
        elit. Sed sit amet tempor neque. Nunc vel sodales velit
        laoreet enim id, hendrerit neque. Nulla fringilla neque
        ultricies tristique accumsan. Vestibulum pharetra eu dolor et aliquam.

        <p style="margin-top: 2em;">
            <span class="cl-ui-button" style="float: left;"><a href="signup">Join Now!</a></span>
            <span class="cl-ui-button" style="float: right;"><a href="addproject">Post a Project</a></span>
        </p>
    </div>
    <?php
    include "templates/footer.php";
    ?>
    <style type="text/css">
        .content {
            background-color: #2573A6;
            background-image: url("../static/img/backgcround.jpg");
            background-size: cover;
            height: 98vh;
        }

        .cl-ui-button {
            padding: 5px 8px;
            background: #42b28c;
            border-radius: 5px;
        }

        .cl-ui-button a {
            color: #fff;
            text-decoration: none;
        }
    </style>

<?php
}

if(isset($_GET['action'])){
    switch($_GET['action']){
        case "signin":
        case "":
        default:
            require "templates/login.php";
            break;
        case "signup":
            require "templates/signup.php";
            break;
        case "logout":
            require "templates/logout.php";
            break;
/*        default:
            mainIndex();*/
    }
}
