<?php
function asEmployer(){
    global $page;
    global $me;
    switch($page){
        case "home":
        default:
            //employer mode not available on mobile yet. so redirect to pc...
            include "employer/home.php";
            break;
        case "new":
            include "employer/new.php";
            break;
        case "history":
            //employer mode not available on mobile yet. so redirect to pc...
            break;
        case "settings":
            include "employer/settings.php";
            break;
        case "messages":
            require "../helpers/message.class.php";
            $partner = false;
            if(isset($_GET['with']) && $_GET['with'] != ""){
                $partner = preg_replace('/[^0-9]+/', '', $_GET['with']);
                $partner = User::getUser($partner);
            }
            $pageTitle = ($partner != false) ? $partner->fullName." - Messages" : "Messages";
            include "messages.php";
            break;
    }
}
function asStudent(){
    global $page;
    global $me;
    switch($page){
        case "messages":
            require "../helpers/message.class.php";
            $partner = false;
            if(isset($_GET['with']) && $_GET['with'] != ""){
                $partner = preg_replace('/[^0-9]+/', '', $_GET['with']);
                $partner = User::getUser($partner);
            }
            $pageTitle = ($partner != false) ? $partner->fullName." - Messages" : "Messages";
            include "messages.php";
            break;
        case "home":
        default:
            $newListings = $me->newListings();
            $listings = $newListings['num_rows'];
            include "student/home.php";
            break;
        case "settings":
            include "student/settings.php";
            break;

        case "myprojects":
            $apps = $me->getApplications();
            $pageCtrls = generatePageLinks(1, $apps['num_rows'], 1, "pp.php", false);
            include "student/archives.php";
        break;
    }
}


if($me->utype == "student"){
    asStudent();
}
else{
    asEmployer();
}