<?php
session_start();
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

$job_id = $_GET['id'] ?? null;

if (!$job_id || !is_numeric($job_id)) {
    die("Invalid job ID.");
}

$stmt = $conn->prepare("SELECT title, description, location, contract_type, created_at FROM jobs WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Job not found.");
}

$job = $result->fetch_assoc();

include 'header.php';
include 'navbar.php';
?>

<main class="job-details" style="max-width: 800px; margin: auto; padding: 20px;">
    <h1><?= htmlspecialchars($job['title']) ?></h1>
    <p><strong>Location:</strong> <?= htmlspecialchars($job['location']) ?></p>
    <p><strong>Contract Type:</strong> <?= htmlspecialchars($job['contract_type']) ?></p>
    <p><strong>Posted on:</strong> <?= date("F j, Y", strtotime($job['created_at'])) ?></p>
    <hr>
    <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'candidate'): ?>
        <form method="POST" action="apply.php" style="margin-top: 20px;">
            <input type="hidden" name="job_id" value="<?= $job_id ?>">
            <button type="submit" class="btn">Apply Now</button>
        </form>
    <?php else: ?>
        <p style="margin-top: 20px;"><em>Login as a candidate to apply for this job.</em></p>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>