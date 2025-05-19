<?php
session_start();

// Gerar captcha apenas se NÃO for um POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $a = rand(1, 9);
    $b = rand(1, 9);
    $op = '+';
    $_SESSION['captcha_question'] = "$a + $b";
    $_SESSION['captcha_result'] = $a + $b;
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
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $captcha = trim($_POST['captcha']);

    if (!isset($_SESSION['captcha_result']) || $captcha != $_SESSION['captcha_result']) {
        $_SESSION['error'] = " Captcha incorrect.";
    } else {
        $stmt = $conn->prepare("SELECT id, name, password, type, status FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (!password_verify($password, $user['password'])) {
                $_SESSION['error'] = " Invalid credentials.";
            } elseif ($user['status'] == 0) {
                $_SESSION['error'] = " Your account is currently blocked. Please contact support.";
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_type'] = $user['type'];
                if ($user['type'] === 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: dashboard-" . $user['type'] . ".php");
                }
                exit();
            }
        } else {
            $_SESSION['error'] = " Invalid credentials.";
        }

        $stmt->close();
    }

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - HireZone</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="form-page">
<?php include 'navbar.php'; ?>

<main>
    <h1>Login</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form class="form-box" method="POST" action="login.php">
        <label>Email:
            <input type="email" name="email" required>
        </label>

        <label>Password:
            <input type="password" name="password" required>
        </label>

        <label>Captcha: <?php echo $_SESSION['captcha_question']; ?> = ?
            <input type="text" name="captcha" required>
        </label>

        <button type="submit" class="btn">Login</button>
    </form>

    <p style="margin-top: 20px;">Don’t have an account? <a href="register.php">Register here</a>.</p>
</main>
</body>
</html>
