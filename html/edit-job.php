<?php
session_start();
// Check if the user is logged in and is a company
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'company') {
    header("Location: login.php");
    exit();
}

// Check if the job ID is provided
if (!isset($_GET['id'])) {
    die("Job ID not provided.");
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
$stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ? AND created_by = ?");
$stmt->bind_param("ii", $job_id, $company_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Job not found or unauthorized access.");
}

$job = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $location = trim($_POST['location']);
    $contract = $_POST['contract_type'];
    $description = trim($_POST['description']);

    $update = $conn->prepare("UPDATE jobs SET title = ?, location = ?, contract_type = ?, description = ? WHERE id = ?");
    $update->bind_param("ssssi", $title, $location, $contract, $description, $job_id);
    $update->execute();

    header("Location: dashboard-company.php");
    exit();
}

include 'header.php';
include 'navbar.php';
?>
<main class="form-page">
    <h1>Edit Job</h1>
    <form method="post">
        <label>Job Title:
            <input type="text" name="title" value="<?= htmlspecialchars($job['title']) ?>" required>
        </label>
        <label>Location:
            <input type="text" name="location" value="<?= htmlspecialchars($job['location']) ?>" required>
        </label>
        <label>Contract Type:
            <select name="contract_type" required>
                <option value="full-time" <?= $job['contract_type'] === 'full-time' ? 'selected' : '' ?>>Full-time</option>
                <option value="part-time" <?= $job['contract_type'] === 'part-time' ? 'selected' : '' ?>>Part-time</option>
                <option value="internship" <?= $job['contract_type'] === 'internship' ? 'selected' : '' ?>>Internship</option>
            </select>
        </label>
        <label>Description:
            <textarea name="description" required><?= htmlspecialchars($job['description']) ?></textarea>
        </label>
        <button type="submit" class="btn">Update Job</button>
    </form>
</main>
<?php include 'footer.php'; ?>