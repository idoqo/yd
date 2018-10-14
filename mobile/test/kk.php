<?php
$conn = new PDO("mysql:host=localhost;dbname=internshub", "root", "");
$st = $conn->query("SELECT * FROM activity WHERE sender = 1 OR reciever = 1");
if($st){
    echo $st->rowCount();
}