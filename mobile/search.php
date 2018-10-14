<?php
require "../helpers/settings.config.inc";
require "../helpers/user.class.php";
require "../helpers/Job.php";
require "../helpers/ratings.class.php";
require "../helpers/functions.php";
$query = isset($_GET['query']) ? stripQuotes($_GET['query']) : "";
$page = isset($_GET['page']) ? preg_replace('#[^0-9]#', '', stripQuotes($_GET['page'])) : 1;
$cat = isset($_GET['cat']) ? stripQuotes($_GET['cat']) : "";
$location = isset($_GET['location']) ? stripQuotes($_GET['location']) : "all";
$pageTitle = "Yedoe Search ".stripQuotes($query);
$resPerPage = 10;
include "templates/header.php";

$show = "jobs";
if($me == "guest" || $me->utype == "student"){
    $matches = Job::fetchMatchedJobs($query, $page, $location, $cat);
    $numResults = $matches['num_rows'];
}
else{
    $results = Student::matchUsers(false, $page, $resPerPage);
    $numResults = $results['num_rows'];
    //search users instead
    $show = "users";
}
$lastPage = ceil($numResults/$resPerPage);
//Sanitizing...
if($lastPage < 1){$lastPage = 1;}
if($page < 1){$page = 1;}
if($page > $lastPage){$page = $lastPage;}
$pageCtrls = "" ;
if($lastPage != 1){
    if($page > 1){
        $prev = $page - 1;
        for($i=$page-3;$i<$page;$i++){
            if($i > 0){
                $pageCtrls .= "<a href='search.php?query=$query&page=$i'>$i</a>";
            }
        }
    }
    $pageCtrls .= "<span>".$page."&nbsp;</span>";
    for($i=$page+1;$i<=$lastPage;$i++){
        if($i >= $page+=4){break;}
        $pageCtrls .= "<a href='search.php?query=$query&page=$i'>$i</a>";
    }
}
include "templates/_search.php";