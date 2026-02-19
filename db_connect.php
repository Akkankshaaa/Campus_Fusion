<?php
$host = "localhost";
$dbname = "campus_fusion";
$username = "root";
$password = "";

try {
    // Correct DSN format, no spaces
    $connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Enable error reporting
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}
?>
