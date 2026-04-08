<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../../config/conexion.php';

try {

    $input = json_decode(file_get_contents("php://input"), true);

    if (empty($input['id_profesional'])) {
        throw new Exception("ID requerido");
    }

    $id = $input['id_profesional'];

    // Obtener id_usuario
    $sql = "SELECT id_usuario FROM profesional WHERE id_profesional = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (!$result) {
        throw new Exception("No encontrado");
    }

    $id_usuario = $result['id_usuario'];

    // Desactivar usuario
    $sqlUpdate = "UPDATE usuario SET estado = 0 WHERE id_usuario = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("i", $id_usuario);

    if (!$stmtUpdate->execute()) {
        throw new Exception("Error al desactivar");
    }

    echo json_encode([
        "status" => "success",
        "message" => "Usuario desactivado correctamente"
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}