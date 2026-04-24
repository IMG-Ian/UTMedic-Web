<?php
require_once '../../config/conexion.php';

$response = [];

try {
    $ps = $conn->query("SELECT COUNT(*) as total FROM profesional")->fetch_assoc();
    $pac = $conn->query("SELECT COUNT(*) as total FROM paciente")->fetch_assoc();
    $citas = $conn->query("SELECT COUNT(*) as total FROM cita")->fetch_assoc();
    $emer = $conn->query("SELECT COUNT(*) as total FROM registrar_emergencia")->fetch_assoc();

    $response = [
        "status" => "success",
        "data" => [
            "profesionales" => $ps['total'],
            "pacientes" => $pac['total'],
            "citas" => $citas['total'],
            "emergencias" => $emer['total']  
        ]
    ];

} catch (Exception $e) {
    $response = [
        "status" => "error",
        "message" => $e->getMessage()
    ];
}

header('Content-Type: application/json');
echo json_encode($response);