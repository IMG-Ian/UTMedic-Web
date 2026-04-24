<?php
session_start();
require_once '../config/conexion.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit();
}

$tipo = $_POST['tipo_paciente'] ?? '';
$fecha = $_POST['fecha'] ?? '';
$hora = $_POST['hora'] ?? '';
$id_motivo = $_POST['id_motivo'] ?? 1;

// Get id_profesional
$stmt = $conn->prepare("SELECT id_profesional FROM profesional WHERE id_usuario = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
     echo json_encode(['status' => 'error', 'message' => 'El usuario no es profesional']);
     exit();
}
$id_profesional = $res->fetch_assoc()['id_profesional'];

if ($tipo === 'invitado') {
    $nombre = $_POST['nombre_invitado'] ?? '';
    if (!$nombre) {
        echo json_encode(['status' => 'error', 'message' => 'Falta el nombre del invitado']);
        exit();
    }
    
    $ins = $conn->prepare("INSERT INTO cita (id_paciente, id_profesional, id_motivo, fecha, hora, estado, nombre_invitado) VALUES (NULL, ?, ?, ?, ?, 'agendada', ?)");
    $ins->bind_param("iisss", $id_profesional, $id_motivo, $fecha, $hora, $nombre);
    
} else {
    $matricula = $_POST['matricula_paciente'] ?? '';
    if (!$matricula) {
        echo json_encode(['status' => 'error', 'message' => 'Falta la matricula']);
        exit();
    }
    
    // Buscar paciente
    $s = $conn->prepare("SELECT id_paciente FROM paciente WHERE matricula = ?");
    $s->bind_param("s", $matricula);
    $s->execute();
    $r = $s->get_result();
    if ($r->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Matricula de paciente no encontrada']);
        exit();
    }
    $id_pac = $r->fetch_assoc()['id_paciente'];
    
    $ins = $conn->prepare("INSERT INTO cita (id_paciente, id_profesional, id_motivo, fecha, hora, estado, nombre_invitado) VALUES (?, ?, ?, ?, ?, 'agendada', NULL)");
    $ins->bind_param("iiiss", $id_pac, $id_profesional, $id_motivo, $fecha, $hora);
}

if ($ins->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error BD: ' . $conn->error]);
}
?>