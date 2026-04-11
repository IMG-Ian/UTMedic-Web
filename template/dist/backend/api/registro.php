<?php
// template/dist/backend/api/registro.php
header('Content-Type: application/json; charset=UTF-8');
require_once 'conexion.php';

// Limpiar y obtener datos del POST a traves de JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Ocurrió un error recibiendo los datos."]);
    exit();
}

$correo = trim($data['correo'] ?? '');
$matricula = trim($data['matricula'] ?? '');
$password = $data['password'] ?? '';
$confirm_password = $data['confirm_password'] ?? '';
$nombre = trim($data['nombre'] ?? '');
$apellido_pat = trim($data['apellido_pat'] ?? '');
$apellido_mat = trim($data['apellido_mat'] ?? '');

// 1. Validaciones Básicas
if (empty($correo) || empty($matricula) || empty($password) || empty($nombre) || empty($apellido_pat)) {
    echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
    exit();
}

if ($password !== $confirm_password) {
    echo json_encode(["status" => "error", "message" => "Las contraseñas no coinciden."]);
    exit();
}

try {
    // 2. Revisar si el correo o matrícula ya existen para evitar duplicados en la BD
    $stmtCheck = $conn->prepare("SELECT id_usuario FROM usuario WHERE correo = ?");
    $stmtCheck->bind_param("s", $correo);
    $stmtCheck->execute();
    if ($stmtCheck->get_result()->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "El correo electrónico asociado ya está registrado."]);
        exit();
    }
    
    $stmtCheck2 = $conn->prepare("SELECT id_paciente FROM paciente WHERE matricula = ?");
    $stmtCheck2->bind_param("s", $matricula);
    $stmtCheck2->execute();
    if ($stmtCheck2->get_result()->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Esta matrícula ya está asignada a otro paciente existencial."]);
        exit();
    }

    // 3. Transacción de Doble Inserción (Garantiza que no exista huérfanos)
    $conn->begin_transaction();

    $pwd_hash = password_hash($password, PASSWORD_DEFAULT);
    $rol = 'paciente';

    $stmtUsu = $conn->prepare("INSERT INTO usuario (nombre, apellido_pat, apellido_mat, correo, password, rol, estado, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, 1, NOW())");
    $stmtUsu->bind_param("ssssss", $nombre, $apellido_pat, $apellido_mat, $correo, $pwd_hash, $rol);
    $stmtUsu->execute();
    
    $id_usuario = $conn->insert_id;

    $stmtPac = $conn->prepare("INSERT INTO paciente (id_usuario, matricula) VALUES (?, ?)");
    $stmtPac->bind_param("is", $id_usuario, $matricula);
    $stmtPac->execute();

    $conn->commit();

    echo json_encode(["status" => "success", "message" => "Registro completado exitosamente."]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => "Fallo interno de Base de Datos."]);
}
?>
