<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success">
    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
  </div>
<?php endif; ?>

<?php if (isset($_SESSION['info'])): ?>
  <div class="alert alert-info">
    <?= $_SESSION['info']; unset($_SESSION['info']); ?>
  </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-error">
    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
  </div>
<?php endif; ?>

<main class="home">
    <section class="hero">
        <img src="../images/logo.png" alt="HireZone Logo" class="logo">
        <h1>Welcome to HireZone</h1>
        <p>Your gateway to job opportunities.</p>
    </section>

    <section class="featured">
        <h2>Featured Jobs</h2>
        <div class="job-cards">
            <div class="card">
                <h3>Software Engineer</h3>
                <p>Company: TechNova</p>
                <p>Location: Dublin</p>
            </div>
            <div class="card">
                <h3>UI/UX Designer</h3>
                <p>Company: DesignCo</p>
                <p>Location: Remote</p>
            </div>
        </div>
    </section>

    <section class="actions">
        <a href="login.php" class="btn">Login</a>
        <a href="opportunities.php" class="btn btn-secondary">View Opportunities</a>
    </section>
</main>

<?php include 'footer.php'; ?>
