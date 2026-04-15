<?php
header('Content-Type: application/json');
require_once '../../config/conexion.php'; // ajusta si tu ruta cambia

try {

    $sql = "SELECT 
                MONTH(fecha) as mes,
                COUNT(*) as total
            FROM cita
            WHERE estado != 'cancelada'
            GROUP BY mes
            ORDER BY mes";

    $result = $conn->query($sql);

    $data = [];

    while($row = $result->fetch_assoc()){
        $data[] = $row;
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