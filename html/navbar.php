<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<nav class="navbar">
  <div class="nav-container">
    <a href="index.php">
      <img src="../images/logo.png" alt="HireZone Logo" class="nav-logo">
    </a>
    <ul class="nav-menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="Opportunities.php">Opportunities</a></li>
        <li><a href="about.php">About</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['user_name']); ?>)</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
  </div>
</nav>
