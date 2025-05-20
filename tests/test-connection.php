<?php
$config = require 'database_connection.php';

$conn = new mysqli(
    $config['db']['host'],
    $config['db']['user'],
    $config['db']['pass'],
    $config['db']['name']
);

// Connection test
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

echo "Database connection working! 🎉";

$conn->close();
