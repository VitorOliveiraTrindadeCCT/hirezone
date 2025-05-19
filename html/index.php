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

$sql = "SELECT id, title, description, location, contract_type FROM jobs ORDER BY created_at DESC LIMIT 6";
$result = $conn->query($sql);

include 'header.php';
include 'navbar.php';
?>

<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success">
    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
  </div>
<?php endif; ?>

<?php if (isset($_SESSION['info'])): ?>
  <div class="alert alert-info">
    <?= $_SESSION['info']; unset($_SESSION['info']); ?>
  </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-error">
    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
  </div>
<?php endif; ?>

<main class="home">
    <section class="hero">
        <video autoplay muted loop playsinline style="width:100%; max-height:400px; object-fit:cover; border-radius:8px; margin-bottom: 20px;">
            <source src="../images/videorh.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <h1>Welcome to HireZone</h1>
        <p>HireZone is your gateway to job opportunities. Our platform connects top companies with the best talent.</p>
        <p>Browse open positions, apply easily, and take the next step in your career — all in one place.</p>
    </section>

    <section class="featured">
        <h2>Latest Job Openings</h2>
        <div class="job-cards">
            <?php while($job = $result->fetch_assoc()): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($job['title']) ?></h3>
                    <p><strong>Location:</strong> <?= htmlspecialchars($job['location']) ?></p>
                    <p><strong>Type:</strong> <?= htmlspecialchars($job['contract_type']) ?></p>
                    <a href="job-details.php?id=<?= $job['id'] ?>" class="btn">View Details</a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>
</main>
