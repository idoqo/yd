<?php
require "../helpers/settings.config.inc";
require "../helpers/user.class.php";
require "../helpers/Job.php";
require "../helpers/ratings.class.php";
require "../helpers/functions.php";
$title = "Profile";
require "templates/header.php";

if($me != "guest") {
    $user = (isset($_GET['user'])) ? $_GET['user'] : false;
    if(($user) && $user != $me->userID){
        header("location: user/$user");
        exit;
    }
    else {
        $user = $me;
        if ($user->utype == "student") {
            require "templates/_profile.php";
        } else {
            $about = $me->getInfo();
            $industry = array();
            if($about['industry'] != ""){
                $industry = getSkills($about['industry']);
                foreach($industry as $ind){
                    //$industry[] = $ind['skill'];
                    $industry = $ind['skill'];
                }
            }
            require "templates/employer/_profile.php";
        }
    }
}
