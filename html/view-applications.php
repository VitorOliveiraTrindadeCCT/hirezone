<?php
session_start();

// Configures the database connection
$config = include '../config/database_connection.php';
$db = $config['db'];
$conn = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);

// Checks for connection errors
if ($conn->connect_error) {
    die("Database connection error: " . $conn->connect_error);
}

// Checks if the user is authenticated and is a company
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'company') {
    header('Location: login.php');
    exit();
}

$company_id = $_SESSION['user_id'];

// Gets the jobs published by the company
$query = "SELECT id, title FROM jobs WHERE created_by = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $company_id);
$stmt->execute();
$result = $stmt->get_result();
$jobs = $result->fetch_all(MYSQLI_ASSOC);

// Checks if a filter has been applied
$selected_job_id = isset($_GET['job_id']) ? (int)$_GET['job_id'] : null;
$applications = [];

if ($selected_job_id) {
    // Gets the applications for the selected job
    $query = "SELECT u.name AS candidate_name, u.email AS candidate_email, a.applied_at AS application_date, a.status AS application_status FROM applications a JOIN users u ON a.user_id = u.id WHERE a.job_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $selected_job_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $applications = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applications</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container" style="text-align: center;">
        <h1>View Applications</h1>

        <form method="GET" action="">
            <label for="job_id">Filter by job:</label>
            <select name="job_id" id="job_id" onchange="this.form.submit()">
                <option value="">Select a job</option>
                <?php foreach ($jobs as $job): ?>
                    <option value="<?= $job['id'] ?>" <?= $selected_job_id == $job['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($job['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php if ($selected_job_id && $applications): ?>
            <h2>Applicants for the job: <?= htmlspecialchars($jobs[array_search($selected_job_id, array_column($jobs, 'id'))]['title']) ?></h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Application Date</th>
                            <th>Application Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $application): ?>
                            <tr>
                                <td><?= htmlspecialchars($application['candidate_name']) ?></td>
                                <td><?= htmlspecialchars($application['candidate_email']) ?></td>
                                <td><?= htmlspecialchars($application['application_date']) ?></td>
                                <td><?= htmlspecialchars($application['application_status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($selected_job_id): ?>
            <p>No applications found for this job.</p>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
