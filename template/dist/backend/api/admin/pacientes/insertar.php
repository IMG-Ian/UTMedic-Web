<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../../config/conexion.php';

try {

    $input = json_decode(file_get_contents("php://input"), true);

    // VALIDACIONES
    if (
        empty($input['nombre']) ||
        empty($input['apellido_pat']) ||
        empty($input['correo']) ||
        empty($input['password']) ||
        empty($input['matricula'])
    ) {
        echo json_encode([
            "status" => "error",
            "message" => "Faltan campos obligatorios"
        ]);
        exit;
    }

    // INSERT USUARIO

    $sqlUsuario = "INSERT INTO usuario 
    (nombre, apellido_pat, apellido_mat, correo, password, rol, estado) 
    VALUES (?, ?, ?, ?, ?, 'paciente', 1)";

    $stmtUser = $conn->prepare($sqlUsuario);

    $passwordHash = password_hash($input['password'], PASSWORD_DEFAULT);

    $apellido_mat = $input['apellido_mat'] ?? null;

    $stmtUser->bind_param(
        "sssss",
        $input['nombre'],
        $input['apellido_pat'],
        $apellido_mat,
        $input['correo'],
        $passwordHash
    );

    if (!$stmtUser->execute()) {
        throw new Exception("Error al insertar usuario");
    }

    // Obtener ID usuario
    $id_usuario = $conn->insert_id;

    // INSERT PACIENTE

    $sqlPaciente = "INSERT INTO paciente 
    (id_usuario, matricula, carrera, telefono, contacto_emergencia, alergias, padecimientos) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmtPaciente = $conn->prepare($sqlPaciente);

    // valores opcionales
    $carrera = $input['carrera'] ?? null;
    $telefono = $input['telefono'] ?? null;
    $contacto_emergencia = $input['contacto_emergencia'] ?? null;
    $alergias = $input['alergias'] ?? null;
    $padecimientos = $input['padecimientos'] ?? null;

    $stmtPaciente->bind_param(
        "issssss",
        $id_usuario,
        $input['matricula'],
        $carrera,
        $telefono,
        $contacto_emergencia,
        $alergias,
        $padecimientos
    );

    if (!$stmtPaciente->execute()) {
        throw new Exception("Error al insertar paciente");
    }

    // RESPUESTA

    echo json_encode([
        "status" => "success",
        "message" => "Paciente registrado correctamente"
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}