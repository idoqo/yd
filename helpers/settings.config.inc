<?php

/*ini_set("log_errors", 1);
ini_set("error_log", "http://localhost/internshub/global/tmp.log.txt");
function logError($errno, $msg, $errfile){
    $ip = $_SERVER['REMOTE_ADDR'];
    $time = date('D, d/m/Y at H:i:sa');
    
    error_log("TYPE: ".$errno." :::MSG: ".$msg.":::EVENT TIME: ".$time." :::IP: ".$ip." :::FILE: ".$errfile."\n");
    return true;
}

set_error_handler("logError");*/
define("DB_DSN", "mysql:host=localhost;dbname=yedoe");
define("DB_USER", "root");
define("DB_PASS", "");
define("__BASE", "/");
$conn = new PDO(DB_DSN, DB_USER, DB_PASS);
//define("__BASE", "/");
