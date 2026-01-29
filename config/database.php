<?php
 $host = "localhost";
 $dbname = "php_crud";
 $username = "root";
 $password = "";


 try{
    $conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
 }
 catch(PDOException $e) {
    die("connection failed with database".$e->getMessage());
 }
?>