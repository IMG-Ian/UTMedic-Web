<?php
// backend/controlador_perfil.php

// Iniciar sesión para recuperar datos del usuario si no está iniciada
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: auth-login.php");
    exit();
}

require_once __DIR__ . '/config/conexion.php';

$userId = $_SESSION['user_id'];
$userData = [];

// Obtener datos frescos del usuario y paciente/profesional
$stmt = $conn->prepare("SELECT u.*, p.matricula, p.telefono, p.carrera, p.contacto_emergencia, p.alergias, p.padecimientos 
                        FROM usuario u 
                        LEFT JOIN paciente p ON u.id_usuario = p.id_usuario 
                        WHERE u.id_usuario = ?");
if ($stmt) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $userData = $res->fetch_assoc();
    }
    $stmt->close();
}

// Variables base para la vista
$nombreEstudiante = $userData['nombre'] ?? (isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuario');
$rolUsuario = isset($_SESSION['role']) ? ucfirst(strtolower($_SESSION['role'])) : 'Usuario Regular';
$avatarUsuario = !empty($userData['foto_perfil']) ? $userData['foto_perfil'] : (isset($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : 'assets/compiled/jpg/1.jpg');
$apellidos = trim(($userData['apellido_pat'] ?? '') . ' ' . ($userData['apellido_mat'] ?? ''));
$correoUser = $userData['correo'] ?? '';
$telefonoUser = $userData['telefono'] ?? '';
$carreraUser = strtoupper($userData['carrera'] ?? 'N/A');
$matriculaUser = $userData['matricula'] ?? 'N/A';
$padecimientos = $userData['padecimientos'] ?? '';
$alergias = $userData['alergias'] ?? '';
$contacto_emerg = $userData['contacto_emergencia'] ?? '';

// Separar contacto_emergencia si viene en formato "Nombre, Telefono"
$arrContacto = explode(',', $contacto_emerg);
$nombreContacto = trim($arrContacto[0] ?? '');
$telefonoContacto = trim($arrContacto[1] ?? '');

?>
