<?php
// Starts the session
session_start();

// Sets the inactivity timeout (in seconds)
$tempoLimite = 60;

// Checks if the session is active and if the timeout has been exceeded
if (isset($_SESSION['ultimoAcesso'])) {
    $tempoInativo = time() - $_SESSION['ultimoAcesso'];
    if ($tempoInativo > $tempoLimite) {
        // Destroys the session and redirects to the home page
        session_unset();
        session_destroy();
        header("Location: /html/index.php");
        exit();
    }
}

// Updates the timestamp of the last access
$_SESSION['ultimoAcesso'] = time();

return [

    // Banco de Dados
    'db' => [
        'host' => 'localhost',
        'user' => 'hirezone_user',
        'pass' => '123456',
        'name' => 'hirezone',
    ],

    //URL da aplicação
    'app_url' => 'http://hirezone.local',


];
