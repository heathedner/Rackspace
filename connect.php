<?php
//Connection Variables:
session_start();
$dbhost = "localhost";
$dbname = "main";
$dbuser = "root";
$dbpass = 'root$plinzedous0n';

    if(!isset($_SESSION['usern']) && !isset($_SESSION['passwd'])){
        header("Location: index.php");
    } else {
        try{
            //Connect to SQL:
            $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
            // Enable Error Mesaging
            $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
?>