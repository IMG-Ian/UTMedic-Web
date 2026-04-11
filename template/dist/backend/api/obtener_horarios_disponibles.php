<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/conexion.php';
header('Content-Type: application/json');

if (!isset($_GET['id_profesional']) || !isset($_GET['fecha'])) {
    echo json_encode(['status' => 'error', 'message' => 'Faltan parámetros id_profesional o fecha']);
    exit();
}

$idProfesional = (int)$_GET['id_profesional'];
$fecha = $_GET['fecha'];

// Obtener horario del profesional
$stmtProf = $conn->prepare("SELECT horario_inicio, horario_fin FROM profesional WHERE id_profesional = ?");
$stmtProf->bind_param("i", $idProfesional);
$stmtProf->execute();
$resProf = $stmtProf->get_result();

if ($resProf->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Profesional no encontrado']);
    exit();
}
$profesional = $resProf->fetch_assoc();

if (empty($profesional['horario_inicio']) || empty($profesional['horario_fin'])) {
    echo json_encode(['status' => 'error', 'message' => 'El profesional no tiene horario configurado']);
    exit();
}

$inicio = new DateTime($profesional['horario_inicio']);
$fin = new DateTime($profesional['horario_fin']);

// Obtener citas ocupadas ese día
$stmtCitas = $conn->prepare("SELECT hora FROM cita WHERE id_profesional = ? AND fecha = ? AND estado != 'cancelada'");
$stmtCitas->bind_param("is", $idProfesional, $fecha);
$stmtCitas->execute();
$resCitas = $stmtCitas->get_result();
$ocupadas = [];
while ($row = $resCitas->fetch_assoc()) {
    $ocupadas[] = date('H:i:s', strtotime($row['hora']));
}

$disponibles = [];
$current = clone $inicio;
while ($current < $fin) {
    $hora_str = $current->format('H:i:s');
    // Considerar que si el slot ya está ocupado, devolvemos success pero status ocupado
    $is_ocupada = in_array($hora_str, $ocupadas);
    $disponibles[] = [
        'hora_24' => $hora_str,
        'hora_12' => $current->format('h:i A'),
        'disponible' => !$is_ocupada
    ];
    $current->add(new DateInterval('PT30M'));
}

echo json_encode(['status' => 'success', 'data' => $disponibles]);
?>
