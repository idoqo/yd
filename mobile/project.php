<?php
require_once "../helpers/settings.config.inc";
require_once "../helpers/user.class.php";
require_once "../helpers/Job.php";

require_once "templates/header.php";
if(isset($_SESSION['success'])){
    echo $_SESSION['success'];
    unset($_SESSION['success']);
}
$jobId = isset($_GET['job_id']) ? $_GET['job_id'] : "";
if($jobId == ""){
    header("location: search.php");
    exit();
}
$details = Job::getById($jobId);
if($details == null){
    header("location: 404.php");
    exit();
}
$pageTitle = $details->title;
$employer = $details->getEmployer();
include "templates/_project.php";