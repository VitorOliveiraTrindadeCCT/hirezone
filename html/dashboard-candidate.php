<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'candidate') {
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

$user_id = $_SESSION['user_id'];

$sql = "SELECT j.title, j.location, j.contract_type, j.id AS job_id, a.applied_at
        FROM applications a
        JOIN jobs j ON a.job_id = j.id
        WHERE a.user_id = ?
        ORDER BY a.applied_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

include 'header.php';
include 'navbar.php';
?>

<main class="form-page">
    <h1>My Applications</h1>

    <?php if ($result->num_rows > 0): ?>
        <div class="card-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="job-card">
                <h2><?= htmlspecialchars($row['title']) ?></h2>
                <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
                <p><strong>Contract:</strong> <?= htmlspecialchars($row['contract_type']) ?></p>
                <p><strong>Applied on:</strong> <?= date("F j, Y", strtotime($row['applied_at'])) ?></p>
                <a class="btn" href="job-details.php?id=<?= $row['job_id'] ?>">View Job</a>
            </div>
        <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>You have not applied to any jobs yet.</p>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>