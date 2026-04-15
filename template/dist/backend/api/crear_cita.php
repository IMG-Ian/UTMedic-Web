<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit();
}

require_once '../config/conexion.php';

// Leemos el payload en crudo como JSON enviado por fetch()
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!isset($data['idPersonal'], $data['fecha'], $data['hora'])) {
     echo json_encode(['status' => 'error', 'message' => 'Faltan datos requeridos (profesional, fecha y hora).']);
     exit();
}

$userId = $_SESSION['user_id'];
$idPersonal = $data['idPersonal'];
$fecha = $data['fecha'];
$hora = $data['hora'];
$observaciones = isset($data['observaciones']) ? trim($data['observaciones']) : '';

// 1. Obtener el id_paciente asociado a este idUsuario
$stmtProfile = $conn->prepare("SELECT id_paciente FROM paciente WHERE id_usuario = ?");
$stmtProfile->bind_param("i", $userId);
$stmtProfile->execute();
$resProfile = $stmtProfile->get_result();

if ($resProfile->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Debes completar tu registro como Paciente (o contactar al administrador) antes de agendar citas.']);
    exit();
}

$perfil = $resProfile->fetch_assoc();
$idPaciente = $perfil['id_paciente'];

// 2. Buscar un id_motivo válido
// Al no elegir uno en el frontend actualmente, usaremos un motivo genérico
$idMotivo = 1;
$resMotivo = $conn->query("SELECT id_motivo FROM motivo LIMIT 1");
if ($resMotivo->num_rows > 0) {
    $mot = $resMotivo->fetch_assoc();
    $idMotivo = $mot['id_motivo'];
} else {
    // Si la tabla de motivos está completamente vacía, creamos uno de escape
    $conn->query("INSERT INTO motivo (descripcion, tipo) VALUES ('Consulta General', 'cita')");
    $idMotivo = $conn->insert_id;
}

// 3. Insertar la nueva cita
// Atamos a los nuevos IDs correspondientes
$sql = "INSERT INTO cita (id_paciente, id_profesional, id_motivo, fecha, hora, observaciones, estado) VALUES (?, ?, ?, ?, ?, ?, 'agendada')";
$stmtInsert = $conn->prepare($sql);
$stmtInsert->bind_param("iiisss", $idPaciente, $idPersonal, $idMotivo, $fecha, $hora, $observaciones);

if ($stmtInsert->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Cita agendada correctamente.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error de base de datos al guardar la cita: ' . $conn->error]);
}
?>
