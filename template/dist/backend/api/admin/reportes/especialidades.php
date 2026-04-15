<?php
session_start();
header('Content-Type: application/json');

// 🔐 Seguridad
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'admin') {
    http_response_code(403);
    echo json_encode([
        "status" => "error",
        "message" => "Acceso no autorizado"
    ]);
    exit;
}

require_once '../../../config/conexion.php';

try {

    $sql = "SELECT 
                p.especialidad,
                COUNT(c.id_cita) AS total
            FROM cita c
            JOIN profesional p 
                ON c.id_profesional = p.id_profesional
            GROUP BY p.especialidad
            ORDER BY total DESC";

    $result = $conn->query($sql);

    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "especialidad" => $row['especialidad'],
            "total" => (int)$row['total']
        ];
    }

    echo json_encode([
        "status" => "success",
        "data" => $data
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}