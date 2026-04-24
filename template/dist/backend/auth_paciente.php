<?php
// backend/auth_paciente.php

// 1. Manejo seguro de la sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Validación de Logueo General
if (!isset($_SESSION['user_id'])) {
    header("Location: auth-login.php");
    exit();
}

// Opcional: Validación de que NO sea un Médico ni Administrador, para restringir los roles
// (Descomentar si es estrictamente obligatorio separar las vistas, actualmente todo usuario puede ver inicio paciente)
/*
if (isset($_SESSION['role']) && !in_array(strtolower($_SESSION['role']), ['paciente', 'usuario'])) {
    // header("Location: acceso_denegado.php");
    // exit();
}
*/

// 3. Declaración y extracción de variables estéticas globales (Avatar, Nombre, etc)
$nombreEstudiante = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuario';
$rolUsuario = isset($_SESSION['role']) ? ucfirst(strtolower($_SESSION['role'])) : 'Usuario Regular';
$avatarUsuario = isset($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : 'assets/compiled/jpg/1.jpg';

?>
