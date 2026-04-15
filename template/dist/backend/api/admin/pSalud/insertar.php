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
        empty($input['especialidad']) ||
        empty($input['cedula'])
    ) {
        echo json_encode([
            "status" => "error",
            "message" => "Faltan campos obligatorios"
        ]);
        exit;
    }

    //INSERT EN USUARIO

    $sqlUsuario = "INSERT INTO usuario 
    (nombre, apellido_pat, apellido_mat, correo, password, rol, estado) 
    VALUES (?, ?, ?, ?, ?, 'profesional', 1)";

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

    // Obtener ID generado
    $id_usuario = $conn->insert_id;

    //INSERT EN PROFESIONAL_SALUD

    $sqlPS = "INSERT INTO profesional 
    (id_usuario, especialidad, cedula, horario_inicio, horario_fin) 
    VALUES (?, ?, ?, ?, ?)";

    $stmtPS = $conn->prepare($sqlPS);

    $stmtPS->bind_param(
        "issss",
        $id_usuario,
        $input['especialidad'],
        $input['cedula'],
        $input['horario_inicio'],
        $input['horario_fin']
    );

    if (!$stmtPS->execute()) {
        throw new Exception("Error al insertar profesional de salud");
    }

    // =========================
    // RESPUESTA
    // =========================

    echo json_encode([
        "status" => "success",
        "message" => "Personal de salud agregado correctamente"
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}