<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit();
}

require_once 'conexion.php';

$sql = "SELECT p.id_profesional as idPersonal, 
               CONCAT(u.nombre, ' ', u.apellido_pat) as nombre, 
               p.especialidad as profesion 
        FROM profesional p
        INNER JOIN usuario u ON p.id_usuario = u.id_usuario
        WHERE u.estado = 1
        ORDER BY u.nombre ASC";
$result = $conn->query($sql);

$professionals = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $professionals[] = [
            'id' => $row['idPersonal'],
            'nombre' => $row['nombre'],
            'profesion' => ucfirst($row['profesion'])
        ];
    }
}

echo json_encode(['status' => 'success', 'data' => $professionals]);
?>
