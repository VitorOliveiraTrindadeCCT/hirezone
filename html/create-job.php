<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'company') {
    header("Location: login.php");
    exit();
}

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $location = trim($_POST['location']);
    $contract = $_POST['contract_type'];
    $description = trim($_POST['description']);
    $created_by = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO jobs (title, location, contract_type, description, created_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $title, $location, $contract, $description, $created_by);
    $stmt->execute();

    header("Location: dashboard-company.php");
    exit();
}

include 'header.php';
include 'navbar.php';
?>
<main class="form-page">
    <h1>Create Job</h1>
    <form method="post">
        <label>Job Title:
            <input type="text" name="title" required>
        </label>
        <label>Location:
            <input type="text" name="location" required>
        </label>
        <label>Contract Type:
            <select name="contract_type" required>
                <option value="full-time">Full-time</option>
                <option value="part-time">Part-time</option>
                <option value="internship">Internship</option>
            </select>
        </label>
        <label>Description:
            <textarea name="description" required></textarea>
        </label>
        <button type="submit" class="btn">Create Job</button>
    </form>
</main>
<?php include 'footer.php'; ?>