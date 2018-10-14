<?php
ob_start();
session_start();
require "../helpers/settings.config.inc";
require "../helpers/user.class.php";
require "../helpers/functions.php";

//test DB connection
try{
    $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
}
catch(PDOException $e){
   // $_SESSION['error'] = $e->getMessage();
    $_SESSION['error'] = "Sorry. We could not complete your registration. Please try again later";
    header("location: ".$_SERVER['HTTP_REFERER']);
    exit;
}