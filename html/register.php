<?php
session_start();

// Gerar captcha dinâmico se ainda não estiver definido
if (!isset($_SESSION['captcha_result'])) {
    $a = rand(1, 9);
    $b = rand(1, 9);
    $op = rand(0, 1) ? '+' : '-';
    $_SESSION['captcha_question'] = "$a $op $b";
    $_SESSION['captcha_result'] = eval("return $a $op $b;");
}

// Processar registro
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

    $type = $_POST['type'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $captcha = trim($_POST['captcha']);

    if (!isset($_SESSION['captcha_result']) || $captcha != $_SESSION['captcha_result']) {
        $_SESSION['error'] = "❌ Captcha incorrect.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "❌ Invalid email address.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $type);

        if ($stmt->execute()) {
            $_SESSION['success'] = "✅ Account created successfully! You can now log in.";
            unset($_SESSION['captcha_result'], $_SESSION['captcha_question']);
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error'] = "❌ Registration failed: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
    header("Location: register.php");
    exit();
}
?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<main class="form-page">
    <h1>Register</h1>
    <form action="register.php" method="POST" class="form-box">
        <label>User Type:
            <select name="type" required>
                <option value="">Select</option>
                <option value="candidate">Candidate</option>
                <option value="company">Company</option>
            </select>
        </label>
        <label>Full Name:
            <input type="text" name="name" required>
        </label>
        <label>Email:
            <input type="email" name="email" required>
        </label>
        <label>Password:
            <input type="password" name="password" required>
        </label>
        <label>What is <?= $_SESSION['captcha_question'] ?> ?
            <input type="text" name="captcha" required>
        </label>
        <button type="submit" class="btn">Register</button>
    </form>
</main>

<?php include 'footer.php'; ?>
