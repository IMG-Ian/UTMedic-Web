<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    return;
    exit();
}

require_once dirname(__DIR__) . '/config/conexion.php';
if (!isset($conn)) return;

$userId = $_SESSION['user_id'];

// Obtener id_paciente
$stmtProfile = $conn->prepare("SELECT id_paciente FROM paciente WHERE id_usuario = ?");
$stmtProfile->bind_param("i", $userId);
$stmtProfile->execute();
$resProfile = $stmtProfile->get_result();

if ($resProfile->num_rows === 0) {
    $citas = [];
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
        c.notas_medicas,        
        CONCAT(u.nombre, ' ', u.apellido_pat) as doctor_nombre,
        p.especialidad as doctor_especialidad
    FROM cita c
    LEFT JOIN profesional p ON c.id_profesional = p.id_profesional
    LEFT JOIN usuario u ON p.id_usuario = u.id_usuario
    WHERE c.id_paciente = ?
    ORDER BY 
        FIELD(c.estado, 'agendada', 'atendida', 'cancelada'),
        CASE WHEN c.estado = 'agendada' THEN c.fecha END ASC,
        CASE WHEN c.estado = 'agendada' THEN c.hora END ASC,
        CASE WHEN c.estado != 'agendada' THEN c.fecha END DESC,
        CASE WHEN c.estado != 'agendada' THEN c.hora END DESC
";

$stmtCitas = $conn->prepare($sql);
$stmtCitas->bind_param("i", $idPaciente);
$stmtCitas->execute();
$resCitas = $stmtCitas->get_result();

$citas = [];
while ($row = $resCitas->fetch_assoc()) {
    $citas[] = $row;
}
