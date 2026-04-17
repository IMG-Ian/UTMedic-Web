<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validar si la sesión está iniciada
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . dirname($_SERVER['SCRIPT_NAME']) . '/../auth-login.php');
    exit();
}

// Validar si el rol en sesión corresponde al perfil Admin
if (!in_array(strtolower($_SESSION['role'] ?? ''), ['admin', 'administrador'])) {
    header('Location: ' . dirname($_SERVER['SCRIPT_NAME']) . '/../auth-login.php');
    exit();
}
?>
