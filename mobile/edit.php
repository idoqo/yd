<?php
/*Edit only when you are ready...GOES with templates/_dashboard.php*/
require_once "../helpers/settings.config.inc";
require_once "../helpers/functions.php";

require_once "../helpers/Job.php";
require_once "../helpers/user.class.php";
require_once "../helpers/ratings.class.php";
$title = "Dashboard";
include "templates/header.php";
if($me == "guest"){
    header("location: signin");
    exit();
}
if($me->utype == "student"){
    include "templates/student/edit_view.php";
    exit();
}

if($me->utype == "emp"){
    include "templates/employer/edit_view.php";
    exit();
}
