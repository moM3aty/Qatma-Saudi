<?php
session_start();

$host = 'localhost';
$dbname = 'u834188565_qatmasaudi'; 
$username = 'u834188565_qatmaAdmin';
$password = '>6$Ae*L;PLw';    

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>