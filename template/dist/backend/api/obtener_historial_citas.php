<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit();
}

require_once '../config/conexion.php';

$userId = $_SESSION['user_id'];

// Obtener id_paciente
$stmtProfile = $conn->prepare("SELECT id_paciente FROM paciente WHERE id_usuario = ?");
$stmtProfile->bind_param("i", $userId);
$stmtProfile->execute();
$resProfile = $stmtProfile->get_result();

if ($resProfile->num_rows === 0) {
    echo json_encode(['status' => 'success', 'data' => []]); // Usuario no es paciente
    exit();
}

$perfil = $resProfile->fetch_assoc();
$idPaciente = $perfil['id_paciente'];

// Consultar todas las citas, uniendo información del doctor y ordenando por fecha más reciente
$sql = "
    SELECT 
        c.id_cita as idCita,
        c.fecha,
        c.hora,
        c.estado,
        c.observaciones,
        '' as notas_medicas,
        CONCAT(u.nombre, ' ', u.apellido_pat) as doctor_nombre,
        p.especialidad as doctor_especialidad
    FROM cita c
    LEFT JOIN profesional p ON c.id_profesional = p.id_profesional
    LEFT JOIN usuario u ON p.id_usuario = u.id_usuario
    WHERE c.id_paciente = ?
    ORDER BY c.fecha DESC, c.hora DESC
";

$stmtCitas = $conn->prepare($sql);
$stmtCitas->bind_param("i", $idPaciente);
$stmtCitas->execute();
$resCitas = $stmtCitas->get_result();

$citas = [];
while ($row = $resCitas->fetch_assoc()) {
    $citas[] = $row;
}

echo json_encode(['status' => 'success', 'data' => $citas]);
?>
