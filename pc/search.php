<?php
$query = isset($_GET['query']) ? strtolower(stripQuotes($_GET['query'])) : false;
$page = isset($_GET['page']) ? preg_replace('#[^0-9]#', '', stripQuotes($_GET['page'])) : 1;
$cat = isset($_GET['cat']) ? stripQuotes($_GET['cat']) : "";
$location = isset($_GET['location']) ? stripQuotes($_GET['location']) : "";
$pageTitle = "Yedoe Search ".stripQuotes($query);
$resPerPage = 10;



$show = "jobs";
if($me == "guest" || $me->utype == "student"){
    $matches = Job::fetchMatchedJobs($query, $page, $location, $cat);
}
else{
    //show users instead
    $show = "users";
}
