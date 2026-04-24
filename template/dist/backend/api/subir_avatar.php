<?php
session_start();
header('Content-Type: application/json');

require_once '../config/conexion.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "No autorizado"
    ]);
    exit();
}

$userId = $_SESSION['user_id'];

// Validar archivo
if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        "status" => "error",
        "message" => "Error al subir archivo"
    ]);
    exit();
}

$file = $_FILES['avatar'];
$fileName = $file['name'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];

// Extensión
$allowedExtensions = ['jpg', 'jpeg', 'png'];
$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

if (!in_array($fileExt, $allowedExtensions)) {
    echo json_encode([
        "status" => "error",
        "message" => "Formato no permitido"
    ]);
    exit();
}

// Tamaño
if ($fileSize > 5 * 1024 * 1024) {
    echo json_encode([
        "status" => "error",
        "message" => "Archivo demasiado grande"
    ]);
    exit();
}

// Carpeta
$uploadDir = '../../frontend/assets/compiled/jpg/avatars/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// 🧠 1. OBTENER Y BORRAR IMAGEN ANTERIOR
$stmtOld = $conn->prepare("SELECT foto_perfil FROM usuario WHERE id_usuario = ?");
$stmtOld->bind_param("i", $userId);
$stmtOld->execute();
$result = $stmtOld->get_result();
$row = $result->fetch_assoc();

if ($row && !empty($row['foto_perfil'])) {
    $oldPath = '../../frontend/' . $row['foto_perfil'];

    // Evitar borrar imagen por defecto
    if (file_exists($oldPath) && strpos($oldPath, 'default') === false) {
        unlink($oldPath);
    }
}

// 🧠 2. GUARDAR NUEVA IMAGEN
$newFileName = 'user_' . $userId . '_' . time() . '.' . $fileExt;
$fileDestination = $uploadDir . $newFileName;

if (!move_uploaded_file($fileTmpName, $fileDestination)) {
    echo json_encode([
        "status" => "error",
        "message" => "Error al guardar imagen"
    ]);
    exit();
}

// Ruta para frontend
$dbPath = 'assets/compiled/jpg/avatars/' . $newFileName;

// 🧠 3. ACTUALIZAR BD
$stmt = $conn->prepare("UPDATE usuario SET foto_perfil = ? WHERE id_usuario = ?");
$stmt->bind_param("si", $dbPath, $userId);

if (!$stmt->execute()) {
    echo json_encode([
        "status" => "error",
        "message" => "Error en BD"
    ]);
    exit();
}

// Guardar en sesión
$_SESSION['user_avatar'] = $dbPath;

// RESPUESTA FINAL
echo json_encode([
    "status" => "success",
    "avatar_url" => $dbPath
]);
exit();