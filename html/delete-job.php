<?php
session_start();
// Check if the user is logged in and is a company
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'company') {
    header("Location: login.php");
    exit();
}

// Check if the job ID is specified
if (!isset($_GET['id'])) {
    die("Job ID not specified.");
}

$job_id = intval($_GET['id']);
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

$company_id = $_SESSION['user_id'];
$stmt = $conn->prepare("DELETE FROM jobs WHERE id = ? AND created_by = ?");
$stmt->bind_param("ii", $job_id, $company_id);
$stmt->execute();

header("Location: dashboard-company.php");
exit();
?>