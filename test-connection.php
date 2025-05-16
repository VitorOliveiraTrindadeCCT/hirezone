<?php
$config = require 'database_connection.php';

$conn = new mysqli(
    $config['db']['host'],
    $config['db']['user'],
    $config['db']['pass'],
    $config['db']['name']
);

// Teste de conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

echo "Conexão com o banco de dados funcionando! 🎉";

$conn->close();
