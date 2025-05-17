
<?php if (isset($_GET['logged_out']) && $_GET['logged_out'] == 1): ?>
  <div class="alert alert-info">
    You have logged out successfully.
  </div>
<?php endif; ?>

<?php
session_start();




if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $captcha = trim($_POST['captcha']);

    if ($captcha !== "5") {
        echo "<p style='color:red'> Captcha incorrect.</p>";
    } else {
        $stmt = $conn->prepare("SELECT id, name, password, type FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_type'] = $user['type'];

                echo "<p style='color:green'>Login successful! Welcome, {$user['name']}.</p>";
                $_SESSION['success'] = "Login successful! Welcome, {$user['name']}.";
                header("Location: index.php");
                exit();// Redirecionar para a área protegida, se quiser
                // header("Location: dashboard.php");
                // exit();
            } else {
                echo "<p style='color:red'> Incorrect password.</p>";
            }
        } else {
            echo "<p style='color:red'> Email not found.</p>";
        }

        $stmt->close();
    }

    $conn->close();
}
?>
<?php
if (isset($_GET['logged_out']) && $_GET['logged_out'] == 1): ?>
  <div class="alert alert-info">You have logged out successfully.</div>
<?php endif;
?>

<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<main class="form-page">
    <h1>Login</h1>
    <form action="login.php" method="POST" class="form-box">
  <label>Email:
    <input type="email" name="email" required>
  </label>
  <label>Password:
    <input type="password" name="password" required>
  </label>
  <label>What is 3 + 2?
    <input type="text" name="captcha" required>
  </label>
  <button type="submit" class="btn">Login</button>
</form>>
</main>

<?php include 'footer.php'; ?>
<p style="text-align:center; margin-top:15px;">
    Don't have an account? <a href="register.php">Register here</a>.
</p>