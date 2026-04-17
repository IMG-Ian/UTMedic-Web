<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/paths.php';

// Validar si la sesión está iniciada
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . FRONTEND_URL . '/auth/auth-login.php');
    exit();
}

// Validar si el rol en sesión corresponde al perfil Admin
if (!in_array(strtolower($_SESSION['role'] ?? ''), ['admin', 'administrador'])) {
    header('Location: ' . FRONTEND_URL . '/auth/auth-login.php');
    exit();
}
?>
