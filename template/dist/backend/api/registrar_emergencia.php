<?php
// template/dist/backend/api/registrar_emergencia.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
    exit();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit();
}

$idUsuario = $_SESSION['user_id'];

// 1. Obtener ID del Profesional
$profStmt = $conn->prepare("SELECT id_profesional FROM profesional WHERE id_usuario = ?");
$profStmt->bind_param("i", $idUsuario);
$profStmt->execute();
$profResult = $profStmt->get_result();

if ($profResult->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Perfil de médico no encontrado."]);
    exit();
}

$idProfesional = $profResult->fetch_assoc()['id_profesional'];

$nombre_paciente = $_POST['nombre_paciente'] ?? '';
$tipo_emergencia = $_POST['tipo_emergencia'] ?? '';
$fecha_emergencia = $_POST['fecha_emergencia'] ?? '';
$hora_emergencia = $_POST['hora_emergencia'] ?? '';
$observaciones = $_POST['observaciones'] ?? '';
$ambulancia = $_POST['ambulanciaRadio'] ?? 'NO';

if (empty($nombre_paciente) || empty($tipo_emergencia) || empty($fecha_emergencia) || empty($hora_emergencia)) {
    echo json_encode(['status' => 'error', 'message' => 'Por favor complete todos los campos requeridos.']);
    exit();
}

try {
    $sql = "INSERT INTO registrar_emergencia (id_profesional, nombre_paciente, tipo_emergencia, fecha, hora, requerimiento_ambulancia, detalles_adicionales) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $idProfesional, $nombre_paciente, $tipo_emergencia, $fecha_emergencia, $hora_emergencia, $ambulancia, $observaciones);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Emergencia registrada correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al ejecutar la consulta."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Ocurrió un error en el servidor: " . $e->getMessage()]);
}
?>
