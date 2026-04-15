<?php
header('Content-Type: application/json');
require_once '../../../config/conexion.php';

try {

    $sql = "SELECT 
                p.id_paciente,
                u.nombre,
                u.apellido_pat,
                u.apellido_mat,
                u.correo,
                IF(u.estado = 1, 'Activo', 'Inactivo') as estado,
                p.matricula,
                p.carrera,
                p.telefono,
                p.contacto_emergencia,
                p.alergias,
                p.padecimientos
            FROM paciente p
            INNER JOIN usuario u 
                ON p.id_usuario = u.id_usuario";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception($conn->error);
    }

    $data = [];

    while ($row = $result->fetch_assoc()) {
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