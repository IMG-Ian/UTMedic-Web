<?php
session_start();

// Validar si la sesión está iniciada
if (!isset($_SESSION['user_id'])) {
    header('Location: logout.php');
    exit();
}

// Validar si el rol en sesión corresponde al perfil Profesional / Médico
if (strtolower($_SESSION['role']) !== 'profesional') {
    header('Location: logout.php');
    exit();
}
?>
