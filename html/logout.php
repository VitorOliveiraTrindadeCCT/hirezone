<?php
session_start();
session_unset();
session_destroy();

// Desativa o cache para evitar que o usuário volte às páginas protegidas
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redireciona com marcador de logout
header("Location: login.php?logged_out=1");
exit();
