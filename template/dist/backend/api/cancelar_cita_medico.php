<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

// Verificar que el usuario tenga sesión y sea Profesional Médico
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'profesional') {
    echo json_encode(["status" => "error", "message" => "No autorizado."]);
    exit();
}

require_once '../config/conexion.php';

// Validar parámetros
if (!isset($_POST['id_cita']) || empty($_POST['id_cita'])) {
    echo json_encode(["status" => "error", "message" => "Falta el ID de la cita a cancelar."]);
    exit();
}

$idCita = intval($_POST['id_cita']);
$userId = $_SESSION['user_id'];

try {
    // 1. Obtener ID del Profesional
    $profStmt = $conn->prepare("SELECT id_profesional FROM profesional WHERE id_usuario = ?");
    $profStmt->bind_param("i", $userId);
    $profStmt->execute();
    $profResult = $profStmt->get_result();

    if ($profResult->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Perfil de médico no encontrado."]);
        exit();
    }

    $idProfesional = $profResult->fetch_assoc()['id_profesional'];

    // 2. Actualizar el estado de la cita a 'cancelada' asegurando correspondencia con el médico
    $sql = "UPDATE cita SET estado = 'cancelada' WHERE id_cita = ? AND id_profesional = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idCita, $idProfesional);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Notificación para el paciente
            $stmtPac = $conn->prepare("SELECT p.id_usuario FROM cita c JOIN paciente p ON c.id_paciente = p.id_paciente WHERE c.id_cita = ?");
            $stmtPac->bind_param("i", $idCita);
            if ($stmtPac->execute()) {
                $resPac = $stmtPac->get_result();
                if ($rowPac = $resPac->fetch_assoc()) {
                    $id_paciente_usuario = $rowPac['id_usuario'];
                    $titulo = "Cita Cancelada";
                    $mensaje = "Tu cita ha sido cancelada por el especialista.";
                    $tipo = "cancelacion";
                    $sqlN = "INSERT INTO notificaciones (usuario_id, titulo, mensaje, tipo) VALUES (?, ?, ?, ?)";
                    $stmtN = $conn->prepare($sqlN);
                    if ($stmtN) {
                        $stmtN->bind_param("isss", $id_paciente_usuario, $titulo, $mensaje, $tipo);
                        $stmtN->execute();
                    }
                }
            }

            echo json_encode(["status" => "success", "message" => "Cita cancelada correctamente."]);
        } else {
            echo json_encode(["status" => "error", "message" => "No se pudo cancelar. Cita no encontrada o ya estaba cancelada."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Fallo de ejecución en la base de datos."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Ocurrió un error en el servidor."]);
}
