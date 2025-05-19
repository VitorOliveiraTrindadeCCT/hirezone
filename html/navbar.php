<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<nav class="navbar">
  <div class="nav-container">
    <a href="index.php">
      <img src="../images/logo.png" alt="HireZone Logo" class="nav-logo">
    </a>
    <ul class="nav-menu">
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'candidate'): ?>
            <li><a href="dashboard-candidate.php">My Applications</a></li>
        <?php elseif (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'company'): ?>
            <li><a href="dashboard-company.php">My Job Postings</a></li>
            <li><a href="create-job.php">Create Job</a></li>
        <?php endif; ?>
  
        <li><a href="index.php">Home</a></li>
        <li><a href="opportunities.php">Opportunities</a></li>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'admin'): ?>
         <li><a href="admin.php">Dashboard Admin</a></li>
         <?php endif; ?>
        <li><a href="about.php">About</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['user_name']); ?>)</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
  </div>
</nav>