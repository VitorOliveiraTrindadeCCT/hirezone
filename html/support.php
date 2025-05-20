<?php
// support.php

// Include the header and navbar
include 'header.php';
include 'navbar.php';
?>



<div class="container">
    <h2>Support Request</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Write your message here" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <?php
    // Simulate email sending
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        echo "<div class='alert alert-success'>Email sent successfully!<br>Name: $name<br>Email: $email<br>Message: $message</div>";
    }
    ?>
</div>

<?php
// Include the footer
include 'footer.php';
?>
