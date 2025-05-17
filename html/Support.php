<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<main class="form-page">
    <h1>Support Form</h1>
    <form action="#" method="post" class="form-box">
        <label>Name:
            <input type="text" name="name" required>
        </label>

        <label>Email:
            <input type="email" name="email" required>
        </label>

        <label>Subject:
            <input type="text" name="subject" required>
        </label>

        <label>Message:
            <textarea name="message" rows="4" required></textarea>
        </label>

        <label>What is 3 + 2?
            <input type="text" name="captcha" required>
        </label>

        <button type="submit" class="btn">Send Message</button>
    </form>
</main>

<?php include 'footer.php'; ?>
