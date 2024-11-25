<?php
    function getPdoConnection() {
        static $pdo = null;
        //DB接続
        try {
            //Password:MAMP='root',XAMPP=''
            $pdo = new PDO('mysql:dbname=gs_db_php02;charset=utf8;host=localhost','root','');
        } catch (PDOException $e) {
            exit('DBConnectError:'.$e->getMessage());
        }
        return $pdo;
    }
?>