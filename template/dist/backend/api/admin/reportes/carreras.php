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
                p.carrera,
                COUNT(c.id_cita) AS total
            FROM cita c
            JOIN paciente p 
                ON c.id_paciente = p.id_paciente
            WHERE p.carrera IS NOT NULL AND p.carrera != ''
            GROUP BY p.carrera
            ORDER BY total DESC";

    $result = $conn->query($sql);

    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "carrera" => $row['carrera'],
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