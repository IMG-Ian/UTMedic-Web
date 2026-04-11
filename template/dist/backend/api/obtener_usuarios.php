<?php
require_once __DIR__ . '/conexion.php';

if (!isset($conn)) {
    $usuariosData = [];
    return;
}

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

$result = $conn->query($sql);
$usuariosData = array();

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $usuariosData[] = $row;
    }
}
?>