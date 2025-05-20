<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
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

// Ações: bloquear, ativar, deletar
if (isset($_GET['action']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($user_id === $_SESSION['user_id']) {
        $_SESSION['error'] = "You cannot modify your own admin account.";
    } else {
        if ($action === 'block') {
            $stmt = $conn->prepare("UPDATE users SET status = 0 WHERE id = ?");
        } elseif ($action === 'activate') {
            $stmt = $conn->prepare("UPDATE users SET status = 1 WHERE id = ?");
        } elseif ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        }

        if (isset($stmt)) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();
            $_SESSION['success'] = "User updated successfully.";
        }
    }

    header("Location: admin.php");
    exit();
}

// Listar todos os usuários
$result = $conn->query("SELECT id, name, email, type, status FROM users ORDER BY id ASC");

include 'header.php';
include 'navbar.php';
?>

<main class="form-page">
    <h1>User Management</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr style="background-color: #eee;">
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($user = $result->fetch_assoc()): ?>
            <tr style="border-bottom: 1px solid #ccc;">
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['type'] ?></td>
                <td><?= $user['status'] == 1 ? 'Active' : 'Blocked' ?></td>
                <td>
  <?php if ($user['id'] !== $_SESSION['user_id']): ?>
    <div class="table-actions">
      <?php if ($user['status'] == 1): ?>
        <a class="btn" href="admin.php?action=block&id=<?= $user['id'] ?>">Block</a>
      <?php else: ?>
        <a class="btn" href="admin.php?action=activate&id=<?= $user['id'] ?>">Activate</a>
      <?php endif; ?>
      <a class="btn" href="admin.php?action=delete&id=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
    </div>
  <?php else: ?>
    <em>Self</em>
  <?php endif; ?>
</td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include 'footer.php'; ?>