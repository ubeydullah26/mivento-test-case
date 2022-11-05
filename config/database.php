<?php

//create database
try{
    $pdo = new PDO("mysql:host=localhost", "root", "");
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `ubeydullah_yilmaz_mivento` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
    $pdo->exec("USE `ubeydullah_yilmaz_mivento`");
}catch (PDOException $e){
    echo $e->getMessage();
}


//Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ubeydullah_yilmaz_mivento";

// Create connection
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
// set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//create tables
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS campaigns (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        date VARCHAR(255) NOT NULL
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS employees (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        campaign_id INT(11),
        name VARCHAR(255) NOT NULL,
        surname VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        employee_id VARCHAR(12) NOT NULL,
        phone VARCHAR(10) NOT NULL,
        point VARCHAR(255) NOT NULL
    )");
} catch (PDOException $e) {
    echo $e->getMessage();
}