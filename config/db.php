<?php
$host = "localhost";
$db   = "np03cy4s250027";
$user = "np03cy4s250027";
$pass = "Ytpx9sxKG0";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=UTF8",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed");
}
