<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/conexion.php';
header('Content-Type: application/json');

if (!isset($_GET['especialidad'])) {
    echo json_encode(['status' => 'error', 'message' => 'Falta parámetro especialidad']);
    exit();
}

$espInt = (int)$_GET['especialidad'];
$map = [
    1 => 'medico',
    2 => 'nutriologo',
    3 => 'psicologo'
];

if (!isset($map[$espInt])) {
    echo json_encode(['status' => 'error', 'message' => 'Especialidad inválida']);
    exit();
}
$espStr = $map[$espInt];

$sql = "SELECT p.id_profesional, u.nombre, u.apellido_pat, u.apellido_mat 
        FROM profesional p 
        JOIN usuario u ON p.id_usuario = u.id_usuario 
        WHERE p.especialidad = ? AND u.estado = 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $espStr);
$stmt->execute();
$res = $stmt->get_result();

$profesionales = [];
while ($row = $res->fetch_assoc()) {
    $nombreCompleto = trim($row['nombre'] . ' ' . $row['apellido_pat'] . ' ' . $row['apellido_mat']);
    $profesionales[] = [
        'id' => $row['id_profesional'],
        'nombre' => $nombreCompleto
    ];
}

echo json_encode(['status' => 'success', 'data' => $profesionales]);
?>
