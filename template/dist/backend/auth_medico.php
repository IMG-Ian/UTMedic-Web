<?php
session_start();

// Validar si la sesión está iniciada
if (!isset($_SESSION['user_id'])) {
    header('Location: ../backend/logout.php');
    exit();
}

// Validar si el rol en sesión corresponde al perfil Profesional / Médico
if (strtolower($_SESSION['role']) !== 'profesional') {
    header('Location: ../backend/logout.php');
    exit();
}
// Load specialty for dynamic menu building
require_once __DIR__ . '/api/conexion.php';
$uid = $_SESSION['user_id'];
    $r = $conn->query("SELECT especialidad FROM profesional WHERE id_usuario = $uid");
    
    $esp = "";
    if ($r && $r->num_rows > 0) {
        while($row = $r->fetch_assoc()) {
            if (trim($row['especialidad']) != "") {
                $esp = trim(strtolower($row['especialidad']));
                break;
            }
        }
    }
    
    // Fallback if DB record is missing or empty
    if ($esp == "") {
        $fallback = strtolower(($_SESSION['user_name'] ?? '') . ' ' . ($_SESSION['correo'] ?? ''));
        if (strpos($fallback, 'nutri') !== false) {
            $esp = 'nutriologo';
        } elseif (strpos($fallback, 'psicolo') !== false) {
            $esp = 'psicologo';
        } else {
            $esp = 'medico';
        }
    }
    
    $_SESSION['especialidad'] = $esp;
?>
