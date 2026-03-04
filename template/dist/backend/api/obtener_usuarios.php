<?php

// Otorgar permisos de CORS por si el frontend y backend se corren en puertos u orígenes diferentes temporalmente
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

// Incluir el archivo de conexión
require_once 'conexion.php';

// Validar que la conexión exista (creada en conexion.php)
if (!isset($conn)) {
    echo json_encode(["status" => "error", "message" => "Error de conexión con la base de datos."]);
    exit();
}

    // Hacemos LEFT JOIN con paciente para obtener matrícula y teléfono si se trata de un estudiante
    $sql = "SELECT 
                u.id_usuario as id, 
                CONCAT(u.nombre, ' ', u.apellido_pat) as nombre, 
                IFNULL(p.matricula, 'N/A') as matricula, 
                u.correo as email,
                IFNULL(p.telefono, 'No registrado') as telefono,
                IF(u.estado = 1, 'Activo', 'Inactivo') as estatus 
            FROM usuario u
            LEFT JOIN paciente p ON u.id_usuario = p.id_usuario 
            ORDER BY u.id_usuario DESC
            LIMIT 100";

// Ejecutar consulta
$result = $conn->query($sql);

$data = array();

if ($result) {
    if ($result->num_rows > 0) {
        // Extraer cada fila de la respuesta y colocarla en el arreglo $data
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        // Devolver respuesta exitosa al Frontend con los datos
        echo json_encode([
            "status" => "success",
            "message" => "Datos obtenidos correctamente",
            "data" => $data
        ]);
    } else {
        // Respuesta si la tabla está vacía
        echo json_encode([
            "status" => "success",
            "message" => "No se encontraron registros.",
            "data" => []
        ]);
    }
} else {
    // Respuesta si hubo un error en la consulta SQL
    echo json_encode([
        "status" => "error",
        "message" => "Error al consultar la base de datos: " . $conn->error
    ]);
}

// Cerrar conexión
$conn->close();
?>
