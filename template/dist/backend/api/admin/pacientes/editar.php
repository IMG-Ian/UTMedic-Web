<?php
header('Content-Type: application/json');
require_once '../../../config/conexion.php';

$data = json_decode(file_get_contents('php://input'), true);

// VALIDACIÓN
if (!$data || !isset($data['id_paciente'])) {
    echo json_encode(["success" => false, "message" => "ID de paciente requerido"]);
    exit;
}

$id_paciente = intval($data['id_paciente']);

// 👤 usuario
$nombre = $data['nombre'] ?? null;
$apellido_pat = $data['apellido_pat'] ?? null;
$apellido_mat = $data['apellido_mat'] ?? null;
$correo = $data['correo'] ?? null;
$estado = isset($data['estado']) ? intval($data['estado']) : null;
$password = $data['password'] ?? null;

// 🧾 paciente
$matricula = $data['matricula'] ?? null;
$carrera = $data['carrera'] ?? null;
$telefono = $data['telefono'] ?? null;
$contacto_emergencia = $data['contacto_emergencia'] ?? null;
$alergias = $data['alergias'] ?? null;
$padecimientos = $data['padecimientos'] ?? null;

try {

    // Obtener id_usuario
    $stmt = $conn->prepare("SELECT id_usuario FROM paciente WHERE id_paciente = ?");
    $stmt->bind_param("i", $id_paciente);
    $stmt->execute();
    $stmt->bind_result($id_usuario);

    if (!$stmt->fetch()) {
        echo json_encode(["success" => false, "message" => "Paciente no encontrado"]);
        exit;
    }
    $stmt->close();

    // TRANSACCIÓN
    $conn->begin_transaction();

    //  UPDATE USUARIO

    if (!empty($password)) {

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt1 = $conn->prepare("
            UPDATE usuario 
            SET nombre = ?, apellido_pat = ?, apellido_mat = ?, correo = ?, estado = ?, password = ?
            WHERE id_usuario = ?
        ");
        $stmt1->bind_param("ssssisi",
            $nombre,
            $apellido_pat,
            $apellido_mat,
            $correo,
            $estado,
            $passwordHash,
            $id_usuario
        );

    } else {

        $stmt1 = $conn->prepare("
            UPDATE usuario 
            SET nombre = ?, apellido_pat = ?, apellido_mat = ?, correo = ?, estado = ?
            WHERE id_usuario = ?
        ");
        $stmt1->bind_param("ssssii",
            $nombre,
            $apellido_pat,
            $apellido_mat,
            $correo,
            $estado,
            $id_usuario
        );
    }

    $stmt1->execute();
    $stmt1->close();

    // UPDATE PACIENTE

    $stmt2 = $conn->prepare("
        UPDATE paciente
        SET matricula = ?, carrera = ?, telefono = ?, contacto_emergencia = ?, alergias = ?, padecimientos = ?
        WHERE id_paciente = ?
    ");

    $stmt2->bind_param("ssssssi",
        $matricula,
        $carrera,
        $telefono,
        $contacto_emergencia,
        $alergias,
        $padecimientos,
        $id_paciente
    );

    $stmt2->execute();
    $stmt2->close();

    // COMMIT
    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "Paciente actualizado correctamente"
    ]);

} catch (Exception $e) {

    $conn->rollback();

    echo json_encode([
        "success" => false,
        "message" => "Error al actualizar: " . $e->getMessage()
    ]);
}