<?php
class Model{
    protected function connect(){
        try{
            return new PDO(DB_DSN, DB_USER, DB_PASS);
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }
}