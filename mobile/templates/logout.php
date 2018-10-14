<?php
session_start();
session_destroy();
if(isset($_COOKIE['logged'])){
    setcookie("logged", null, time()-3600);
}
if(isset($_COOKIE['_intseid'])){
    setcookie("_intseid", null, time()-3600);
}
header("Location: signin");
?>