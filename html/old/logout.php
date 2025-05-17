<?php
session_start();
session_unset();
session_destroy();

// Redireciona com marcador de logout
header("Location: login.php?logged_out=1");
exit();