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

// Filters
$search = $_GET['search'] ?? '';
$location = $_GET['location'] ?? '';

$sql = "SELECT id, title, description, location, contract_type FROM jobs WHERE 1=1";
$params = [];
$types = '';

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
    <h1 style="text-align: center;">Available Job Opportunities</h1>

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
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="job-card">
                    <h2><?= htmlspecialchars($row['title']); ?></h2>
                    <p><strong>Location:</strong> <?= htmlspecialchars($row['location']); ?></p>
                    <p><strong>Contract:</strong> <?= htmlspecialchars($row['contract_type']); ?></p>
                    <p><?= nl2br(htmlspecialchars(substr($row['description'], 0, 100))) . "..."; ?></p>
                    <a class="btn" href="job-details.php?id=<?= $row['id']; ?>">View Details</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No jobs found for the selected criteria.</p>
        <?php endif; ?>
    </div>
</main>

<?php include 'footer.php'; ?>