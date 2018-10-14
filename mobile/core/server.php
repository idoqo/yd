<?php
require "../../helpers/settings.config.inc";

if(isset($_GET['category'])){
    $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
    $sql = "SELECT * FROM skills WHERE skill_category = :cat";
    $st = $conn->prepare($sql);
    $st->bindParam(":cat", $_GET['category']);
    try{
        $st->execute();
        echo "<ul class='skill-list'>";
        while($rows = $st->fetch(PDO::FETCH_ASSOC)){
            echo "<li><input type='checkbox' value='{$rows['skill_id']}' name='skill[]'> {$rows['skill']}</li>";
        }
    }
    catch(PDOException $E){
        echo $E->getMessage();
    }
}