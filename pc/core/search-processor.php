<?php
require "templates/header.php";
require "libr/settings.config.inc";
require "libr/user.class.php" ;
require "libr/job.class.php";

$query = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : "";
$filter = isset($_GET['filter']) ? htmlspecialchar($_GET['filter']) : "";

/*search users..Create a better engine ASAP*/
$matched = User::search($query);
var_dump($matched);