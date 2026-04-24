<?php
// template/dist/backend/api/actualizar_perfil.php
header('Content-Type: application/json; charset=UTF-8');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "No autorizado."]);
    exit();
}

require_once '../config/conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Datos inválidos."]);
    exit();
}

$id_usuario = intval($_SESSION['user_id']);
$nombre = trim($data['nombre'] ?? '');
$correo = trim($data['correo'] ?? '');
$telefono = trim($data['telefono'] ?? '');
$padecimientos = trim($data['padecimientos'] ?? '');
$alergias = trim($data['alergias'] ?? '');

$contacto_nombre = trim($data['contacto_nombre'] ?? '');
$contacto_tel = trim($data['contacto_tel'] ?? '');
$contacto_emergencia = "";
if (!empty($contacto_nombre) || !empty($contacto_tel)) {
    $contacto_emergencia = $contacto_nombre . ", " . $contacto_tel;
}

if (empty($correo)) {
    echo json_encode(["status" => "error", "message" => "El correo es obligatorio."]);
    exit();
}

try {
    $conn->begin_transaction();

    // Actualizar tabla usuario
    $stmtU = $conn->prepare("UPDATE usuario SET correo = ? WHERE id_usuario = ?");
    $stmtU->bind_param("si", $correo, $id_usuario);
    $stmtU->execute();

    // Actualizar tabla paciente si aplica
    $role = strtolower($_SESSION['role'] ?? '');
    if ($role === 'paciente') {
        $stmtP = $conn->prepare("UPDATE paciente SET telefono = ?, padecimientos = ?, alergias = ?, contacto_emergencia = ? WHERE id_usuario = ?");
        $stmtP->bind_param("ssssi", $telefono, $padecimientos, $alergias, $contacto_emergencia, $id_usuario);
        $stmtP->execute();
    }

    $conn->commit();

    // Actualizar variables de sesión para que se reflejen arriba en la navbar
    // Para simplificar asumo que se llama 'user_name'
    $stmtCheck = $conn->prepare("SELECT nombre, apellido_pat FROM usuario WHERE id_usuario = ?");
    $stmtCheck->bind_param("i", $id_usuario);
    $stmtCheck->execute();
    $resCheck = $stmtCheck->get_result();
    if ($rowCheck = $resCheck->fetch_assoc()) {
        $_SESSION['user_name'] = $rowCheck['nombre'] . ' ' . $rowCheck['apellido_pat'];
    }

    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => "Error de BD: " . $e->getMessage()]);
}
?>