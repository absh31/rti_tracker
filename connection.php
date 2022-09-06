<?php
$server = "localhost";
$username = "root";
$password = "";
$db = "rti_tracker";

try {
    $conn = new PDO("mysql:host=$server;dbname=$db", $username, $password);
} catch (PDOException $e) {
    header('location: error.php');
    die();
}
