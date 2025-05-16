<?php
$config = require 'database_connection.php';

$conn = new mysqli(
    $config['db']['host'],
    $config['db']['user'],
    $config['db']['pass'],
    $config['db']['name']
);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

echo "Hello, Zita!";
echo "Database is conected :)";

$conn->close();
