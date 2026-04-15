<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'admin') {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Acceso no autorizado"]);
    exit;
}

require_once '../../../config/conexion.php';

try {

    $sqlTotal = "SELECT COUNT(*) as total FROM cita";
    $total = $conn->query($sqlTotal)->fetch_assoc()['total'];

    $sqlAtendidas = "SELECT COUNT(*) as total FROM cita WHERE estado = 'atendida'";
    $atendidas = $conn->query($sqlAtendidas)->fetch_assoc()['total'];

    $sqlAgendadas = "SELECT COUNT(*) as total FROM cita WHERE estado = 'agendada'";
    $agendadas = $conn->query($sqlAgendadas)->fetch_assoc()['total'];

    $sqlCanceladas = "SELECT COUNT(*) as total FROM cita WHERE estado = 'cancelada'";
    $canceladas = $conn->query($sqlCanceladas)->fetch_assoc()['total'];

    $sqlEmergencias = "SELECT COUNT(*) as total FROM emergencias";
    $emergencias = $conn->query($sqlEmergencias)->fetch_assoc()['total'];

    $tasa_asistencia = ($total > 0) ? round(($atendidas / $total) * 100, 2) : 0;
    $no_show = ($total > 0) ? round(($canceladas / $total) * 100, 2) : 0;

    echo json_encode([
        "status" => "success",
        "data" => [
            "total_citas" => (int)$total,
            "atendidas" => (int)$atendidas,
            "agendadas" => (int)$agendadas,
            "canceladas" => (int)$canceladas,
            "emergencias" => (int)$emergencias,
            "tasa_asistencia" => (float)$tasa_asistencia,
        ]
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}