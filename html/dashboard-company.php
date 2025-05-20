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

// Filters
$search = $_GET['search'] ?? '';
$location = $_GET['location'] ?? '';

$sql = "SELECT id, title, location, contract_type, created_at FROM jobs WHERE created_by = ?";
$params = [$company_id];
$types = 'i';

if (!empty($search)) {
    $sql .= " AND (title LIKE ? OR description LIKE ?)";
    $params[] = "%{$search}%";
    $params[] = "%{$search}%";
    $types .= 'ss';
}

if (!empty($location)) {
    $sql .= " AND location = ?";
    $params[] = $location;
    $types .= 's';
}

$sql .= " ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

include 'header.php';
include 'navbar.php';
?>

<main class="job-listing">
    <h1 style="text-align: center;">My Job Postings</h1>

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

    <div class="card-container">
        <?php if ($result->num_rows > 0): ?>
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
        <?php else: ?>
            <p>No jobs found for the selected criteria.</p>
        <?php endif; ?>
    </div>
</main>

<?php include 'footer.php'; ?>