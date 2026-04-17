<?php
header('Content-Type: application/json');
require_once '../../config/conexion.php';

try {

    $sql = "SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN u.estado = 1 THEN 1 ELSE 0 END) as activos,
            SUM(CASE WHEN u.estado = 0 THEN 1 ELSE 0 END) as inactivos
        FROM profesional p
        INNER JOIN usuario u ON p.id_usuario = u.id_usuario";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception($conn->error);
    }

    $data = $result->fetch_assoc();

    echo json_encode([
        "status" => "success",
        "data" => [
            "total" => (int)$data['total'],
            "activos" => (int)$data['activos'],
            "inactivos" => (int)$data['inactivos']
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}