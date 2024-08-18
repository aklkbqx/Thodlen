<?php
$servername = "mysql-thodlen";
$username = "username";
$password = "password";
$database = "thodlen_db";
$port = "9906"; //3306

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database;", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
