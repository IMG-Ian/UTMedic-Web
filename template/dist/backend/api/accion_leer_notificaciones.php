<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/conexion.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "No autorizado"]);
    exit();
}

$userId = $_SESSION['user_id'];
$sql = "UPDATE notificaciones SET leida = 1 WHERE usuario_id = ? AND leida = 0";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    echo json_encode(["status" => "success", "message" => "Notificaciones marcadas como leidas"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al ejecutar consulta"]);
}
?>