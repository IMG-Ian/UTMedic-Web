<?php
header('Content-Type: application/json');
require_once '../../../config/conexion.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id_profesional'])) {
    echo json_encode(["success" => false, "message" => "ID de profesional requerido"]);
    exit;
}

$id_profesional = intval($data['id_profesional']);
$nombre = $data['nombre'] ?? null;
$apellido_pat = $data['apellido_pat'] ?? null;
$apellido_mat = $data['apellido_mat'] ?? null;
$correo = $data['correo'] ?? null;
$estado = isset($data['estado']) ? intval($data['estado']) : null;
$especialidad = $data['especialidad'] ?? null;
$cedula = $data['cedula'] ?? null;
$password = $data['password'] ?? null;
$horario_inicio = $data['horario_inicio'] ?? null;
$horario_fin = $data['horario_fin'] ?? null;

try {
    $stmt = $conn->prepare("SELECT id_usuario FROM profesional WHERE id_profesional = ?");
    $stmt->bind_param("i", $id_profesional);
    $stmt->execute();
    $stmt->bind_result($id_usuario);

    if (!$stmt->fetch()) {
        echo json_encode(["success" => false, "message" => "Profesional no encontrado"]);
        exit;
    }
    $stmt->close();

    $conn->begin_transaction();

    if (!empty($password)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt1 = $conn->prepare("
            UPDATE usuario 
            SET nombre = ?, apellido_pat = ?, apellido_mat = ?, correo = ?, estado = ?, password = ?
            WHERE id_usuario = ?
        ");
        $stmt1->bind_param("ssssisi", $nombre, $apellido_pat, $apellido_mat, $correo, $estado, $passwordHash, $id_usuario);

    } else {
        $stmt1 = $conn->prepare("
            UPDATE usuario 
            SET nombre = ?, apellido_pat = ?, apellido_mat = ?, correo = ?, estado = ?
            WHERE id_usuario = ?
        ");
        $stmt1->bind_param("ssssii", $nombre, $apellido_pat, $apellido_mat, $correo, $estado, $id_usuario);
    }

    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $conn->prepare("
        UPDATE profesional
        SET especialidad = ?, cedula = ?, horario_inicio = ?, horario_fin = ?
        WHERE id_profesional = ?
    ");
    $stmt2->bind_param("ssssi", $especialidad, $cedula, $horario_inicio, $horario_fin, $id_profesional);
    $stmt2->execute();
    $stmt2->close();

    $conn->commit();
    echo json_encode(["success" => true, "message" => "Profesional actualizado correctamente"]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => "Error al actualizar: " . $e->getMessage()]);
}