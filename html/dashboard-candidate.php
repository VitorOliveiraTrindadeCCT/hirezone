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

// Filtros
$search = $_GET['search'] ?? '';
$location = $_GET['location'] ?? '';

$sql = "SELECT j.title, j.location, j.contract_type, j.id AS job_id, a.applied_at
        FROM applications a
        JOIN jobs j ON a.job_id = j.id
        WHERE a.user_id = ?";

$params = [$user_id];
$types = 'i';

if (!empty($search)) {
    $sql .= " AND (j.title LIKE ? OR j.location LIKE ?)";
    $params[] = "%{$search}%";
    $params[] = "%{$search}%";
    $types .= 'ss';
}

if (!empty($location)) {
    $sql .= " AND j.location = ?";
    $params[] = $location;
    $types .= 's';
}

$sql .= " ORDER BY a.applied_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

include 'header.php';
include 'navbar.php';
?>

<main class="form-page">
    <h1>My Applications</h1>

    <form method="GET" class="filter-form">
        <input type="text" name="search" placeholder="Search by keyword" value="<?= htmlspecialchars($search) ?>">
        <select name="location">
            <option value="">All Locations</option>
            <option value="Dublin" <?= $location == 'Dublin' ? 'selected' : '' ?>>Dublin</option>
            <option value="Remote" <?= $location == 'Remote' ? 'selected' : '' ?>>Remote</option>
            <option value="Cork" <?= $location == 'Cork' ? 'selected' : '' ?>>Cork</option>
            <option value="Limerick" <?= $location == 'Limerick' ? 'selected' : '' ?>>Limerick</option>
            <option value="Galway" <?= $location == 'Galway' ? 'selected' : '' ?>>Galway</option>
        </select>
        <button type="submit">Filter</button>
    </form>

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
        <p>No applications found for the selected criteria.</p>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>