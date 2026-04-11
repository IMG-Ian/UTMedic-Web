<?php
// controlador_inicio_paciente.php
// Este controlador centraliza la lógica de carga de lado del servidor para el Dashboard (index.php) del Paciente.

require_once __DIR__ . '/api/conexion.php';

// Validar que exista la sesión en el archivo que importa este controlador
if (!isset($_SESSION['user_id'])) {
    header("Location: auth-login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$today = date('Y-m-d');

// 1. Obtener ID del Paciente asociado al Usuario logueado
$profileStmt = $conn->prepare("SELECT id_paciente FROM paciente WHERE id_usuario = ?");
$profileStmt->bind_param("i", $userId);
$profileStmt->execute();
$profileResult = $profileStmt->get_result();
$idPaciente = ($profileResult->num_rows > 0) ? $profileResult->fetch_assoc()['id_paciente'] : 0;

// 2. Extraer las "Próximas Citas" desde BD filtrando estados para el SSR del Carrusel
$citasFront = [];
if ($idPaciente > 0) {
    $sqlCitas = "
        SELECT 
            c.id_cita as idCita, 
            c.fecha, 
            c.hora, 
            c.estado,
            CONCAT(u.nombre, ' ', u.apellido_pat) AS profesional,
            ps.especialidad AS especialidad
        FROM cita c
        INNER JOIN profesional ps ON c.id_profesional = ps.id_profesional
        INNER JOIN usuario u ON ps.id_usuario = u.id_usuario
        WHERE c.id_paciente = ? 
          AND c.estado NOT IN ('cancelada', 'completada', 'atendida')
        ORDER BY c.fecha ASC, c.hora ASC
        LIMIT 10
    ";
    
    $stmtCitas = $conn->prepare($sqlCitas);
    $stmtCitas->bind_param("i", $idPaciente);
    $stmtCitas->execute();
    $resultCitas = $stmtCitas->get_result();
    
    while ($row = $resultCitas->fetch_assoc()) {
         // Formatear hora de 24h a 12h AM/PM para el frontend
        $row['horario'] = date("h:i A", strtotime($row['hora']));
        $citasFront[] = $row;
    }
}

// 3. Preparar vector de fechas para el Calendario Dinámico (usado después abajo en JS)
$fechasJS = array_column($citasFront, 'fecha');
?>
