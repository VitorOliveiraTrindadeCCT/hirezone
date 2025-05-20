<?php
session_start();
// Check if the user is logged in and is a company
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
<main class="container">
    <h2>Create Job</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="title">Job Title:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter job title" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <select class="form-control" id="location" name="location" required>
                <option value="">Select a city</option>
                <option value="Athlone">Remote</option>
                <option value="Dublin">Dublin</option>
                <option value="Cork">Cork</option>
                <option value="Limerick">Limerick</option>
                <option value="Galway">Galway</option>
                <option value="Waterford">Waterford</option>
                <option value="Drogheda">Drogheda</option>
                <option value="Swords">Swords</option>
                <option value="Dundalk">Dundalk</option>
                <option value="Bray">Bray</option>
                <option value="Navan">Navan</option>
                <option value="Ennis">Ennis</option>
                <option value="Kilkenny">Kilkenny</option>
                <option value="Tralee">Tralee</option>
                <option value="Carlow">Carlow</option>
                <option value="Newbridge">Newbridge</option>
                <option value="Balbriggan">Balbriggan</option>
                <option value="Naas">Naas</option>
                <option value="Athlone">Athlone</option>
                <option value="Portlaoise">Portlaoise</option>
            </select>
        </div>
        <div class="form-group">
            <label for="contract_type">Contract Type:</label>
            <select class="form-control" id="contract_type" name="contract_type" required>
                <option value="full-time">Full-time</option>
                <option value="part-time">Part-time</option>
                <option value="internship">Internship</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter job description" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Job</button>
    </form>
</main>
<?php include 'footer.php'; ?>