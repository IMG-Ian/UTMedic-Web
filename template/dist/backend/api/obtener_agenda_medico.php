<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'profesional') {
    echo json_encode(["status" => "error", "message" => "No autorizado."]);
    exit();
}

require_once '../config/conexion.php';

// Habilitar errores temporalmente para debug (luego hay que quitarlo)
ini_set('display_errors', 1);
error_reporting(E_ALL);

$userId = $_SESSION['user_id'];

try {
    // 1. Obtener ID del Profesional
    $profStmt = $conn->prepare("SELECT id_profesional FROM profesional WHERE id_usuario = ?");
    $profStmt->bind_param("i", $userId);
    $profStmt->execute();
    $profResult = $profStmt->get_result();

    if ($profResult->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Perfil de médico no encontrado."]);
        exit();
    }

    $idProfesional = $profResult->fetch_assoc()['id_profesional'];

    // 2. Obtener todas las citas del profesional (Pendientes y Atendidas)
    // Ordenamos primero por fecha descendente (más recientes arriba) y luego hora ascendente
    // Para la agenda es mejor ordenar las no completadas primero o simplemente por fecha futura más cercana
    $sql = "
        SELECT 
            c.id_cita, 
            c.fecha, 
            c.hora, 
            c.estado,
            c.observaciones AS motivo,
            u.nombre,
            u.apellido_pat,
            u.apellido_mat,
            p.matricula,
            u.foto_perfil
        FROM cita c
        INNER JOIN paciente p ON c.id_paciente = p.id_paciente
        INNER JOIN usuario u ON p.id_usuario = u.id_usuario
        WHERE c.id_profesional = ?
        ORDER BY 
            CASE WHEN c.estado = 'pendiente' THEN 1 ELSE 2 END,
            c.fecha ASC, 
            c.hora ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idProfesional);
    $stmt->execute();
    $result = $stmt->get_result();

    $citas = [];
    while ($row = $result->fetch_assoc()) {
        $horaEmpezar = date("h:i A", strtotime($row['hora']));
        $horaTerminar = date("h:i A", strtotime($row['hora'] . " +1 hour"));
        
        $nombreCompleto = trim($row['nombre'] . ' ' . $row['apellido_pat'] . ' ' . $row['apellido_mat']);
        $foto = !empty($row['foto_perfil']) ? htmlspecialchars($row['foto_perfil']) : 'assets/compiled/jpg/1.jpg'; // fallback
        
        $citas[] = [
            "id_cita" => $row['id_cita'],
            "fechaFormateada" => date("d M Y", strtotime($row['fecha'])),
            "fechaOriginal" => $row['fecha'],
            "horario" => "$horaEmpezar - $horaTerminar",
            "paciente" => htmlspecialchars($nombreCompleto),
            "matricula" => htmlspecialchars($row['matricula']),
            "estado" => strtolower($row['estado']),
            "motivo" => htmlspecialchars($row['motivo'] ?? 'Control de rutina'),
            "foto" => $foto
        ];
    }

    $payload = ["status" => "success", "data" => $citas];
    file_put_contents('debug_agenda.txt', json_encode($payload, JSON_PRETTY_PRINT));
    echo json_encode($payload);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Ocurrió un error al procesar la solicitud."]);
}
?>
