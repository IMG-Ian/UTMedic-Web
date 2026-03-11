<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "No autorizado"]);
    exit();
}

require_once 'conexion.php';

$userId = $_SESSION['user_id'];
$today = date('Y-m-d');

// Consulta para obtener las próximas citas del usuario (paciente o médico dependiendo del id), limitadas a 10.
// Relacionamos cita -> perfil para consultar quien es el paciente, o personal_salud para el médico. 
// Para el usuario, asumimos que su idPerfil o idPersonal están unidos por idUsuario.

// Vamos a buscar el perfil del paciente
$profileStmt = $conn->prepare("SELECT id_paciente FROM paciente WHERE id_usuario = ?");
$profileStmt->bind_param("i", $userId);
$profileStmt->execute();
$profileResult = $profileStmt->get_result();

if ($profileResult->num_rows === 0) {
    echo json_encode(["status" => "success", "data" => []]);
    exit();
}

$profile = $profileResult->fetch_assoc();
$idPaciente = $profile['id_paciente'];

// Traer citas futuras usando el id_paciente, uniendo con profesional y usuario para sacar el nombre de pila
$sql = "
    SELECT 
        c.id_cita as idCita, 
        c.fecha, 
        c.hora, 
        c.estado,
        CONCAT(u.nombre, ' ', u.apellido_pat) AS nombre_profesional,
        ps.especialidad AS especialidad
    FROM cita c
    INNER JOIN profesional ps ON c.id_profesional = ps.id_profesional
    INNER JOIN usuario u ON ps.id_usuario = u.id_usuario
    WHERE c.id_paciente = ? 
      AND c.fecha >= ?
      AND c.estado NOT IN ('cancelada', 'completada', 'atendida')
    ORDER BY c.fecha ASC, c.hora ASC
    LIMIT 10
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $idPaciente, $today);
$stmt->execute();
$result = $stmt->get_result();

$citas = [];
while ($row = $result->fetch_assoc()) {
    // Formatear la hora militar a formato 12 horas AM/PM
    $horaFormateada = date("h:i A", strtotime($row['hora']));
    // Calculamos una supuesta hora de término de 1 hr para pintar en UI
    $horaFin = date("h:i A", strtotime($row['hora'] . " +1 hour"));
    
    $citas[] = [
        "id" => $row['idCita'],
        "fecha" => $row['fecha'],
        "horario" => "$horaFormateada - $horaFin",
        "profesional" => $row['nombre_profesional'],
        "especialidad" => $row['especialidad'],
        "estado" => $row['estado']
    ];
}

echo json_encode(["status" => "success", "data" => $citas]);
?>
