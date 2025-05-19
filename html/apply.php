<?php
session_start();
$config = require '../config/database_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'candidate') {
    die("Access denied.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $job_id = $_POST['job_id'] ?? null;

    if (!$job_id || !is_numeric($job_id)) {
        die("Invalid job ID.");
    }

    $conn = new mysqli(
        $config['db']['host'],
        $config['db']['user'],
        $config['db']['pass'],
        $config['db']['name']
    );

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if already applied
    $check = $conn->prepare("SELECT id FROM applications WHERE user_id = ? AND job_id = ?");
    $check->bind_param("ii", $user_id, $job_id);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $_SESSION['error'] = "⚠️ You have already applied to this job.";
        header("Location: job-details.php?id=" . $job_id);
        exit();
    }

    // Insert application
    $stmt = $conn->prepare("INSERT INTO applications (user_id, job_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $job_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "✅ Your application has been submitted successfully.";
    } else {
        $_SESSION['error'] = "❌ Failed to submit your application. Please try again.";
    }

    $stmt->close();
    $conn->close();

    header("Location: job-details.php?id=" . $job_id);
    exit();
}
?>