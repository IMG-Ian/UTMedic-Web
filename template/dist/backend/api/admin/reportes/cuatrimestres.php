<?php
session_start();
header('Content-Type: application/json');

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
                CASE 
                    WHEN MONTH(fecha) BETWEEN 1 AND 4 THEN 'Ene-Abr'
                    WHEN MONTH(fecha) BETWEEN 5 AND 8 THEN 'May-Ago'
                    WHEN MONTH(fecha) BETWEEN 9 AND 12 THEN 'Sep-Dic'
                END AS cuatrimestre,
                COUNT(*) AS total
            FROM cita
            GROUP BY cuatrimestre
            ORDER BY cuatrimestre";

    $result = $conn->query($sql);

    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "cuatrimestre" => $row['cuatrimestre'],
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