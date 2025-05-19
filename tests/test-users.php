<?php
$config = require '../config/database_connection.php';

$conn = new mysqli(
    $config['db']['host'],
    $config['db']['user'],
    $config['db']['pass'],
    $config['db']['name']
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT COUNT(*) AS total FROM users");
$row = $result->fetch_assoc();

echo " Tabela 'users' conectada. Total de usuários: " . $row['total'];

$conn->close();
?>
