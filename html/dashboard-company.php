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

$company_id = $_SESSION['user_id'];

$sql = "SELECT id, title, location, contract_type, created_at
        FROM jobs
        WHERE created_by = ?
        ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();

include 'header.php';
include 'navbar.php';
?>

<main class="form-page">
    <h1>My Job Postings</h1>

    <?php if ($result->num_rows > 0): ?>
        <div class="card-container">
        <?php while ($job = $result->fetch_assoc()): ?>
            <div class="job-card">
                <h2><?= htmlspecialchars($job['title']) ?></h2>
                <p><strong>Location:</strong> <?= htmlspecialchars($job['location']) ?></p>
                <p><strong>Contract:</strong> <?= htmlspecialchars($job['contract_type']) ?></p>
                <p><strong>Posted on:</strong> <?= date("F j, Y", strtotime($job['created_at'])) ?></p>
                <div style="display:flex; gap:10px;">
                    <a class="btn" href="edit-job.php?id=<?= $job['id'] ?>">Edit</a>
                    <a class="btn" href="delete-job.php?id=<?= $job['id'] ?>" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>You have not posted any jobs yet.</p>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>