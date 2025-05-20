<?php
session_start();
session_unset();
session_destroy();

// Disables cache to prevent users from returning to protected pages
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirects with a logout marker
header("Location: login.php?logged_out=1");
exit();
