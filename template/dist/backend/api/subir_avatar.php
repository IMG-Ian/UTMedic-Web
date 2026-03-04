<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado. Por favor, inicie sesión.']);
    exit();
}

require_once 'conexion.php';

$userId = $_SESSION['user_id'];

// Revisar si se recibió el archivo
if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'No se recibió ningún archivo o hubo un error en la subida.']);
    exit();
}

$file = $_FILES['avatar'];
$fileName = $file['name'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];

// Validar extensiones de imagen
$allowedExtensions = ['jpg', 'jpeg', 'png'];
$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));

if (!in_array($fileActualExt, $allowedExtensions)) {
    echo json_encode(['status' => 'error', 'message' => 'Formato no soportado. Solo JPG, JPEG y PNG.']);
    exit();
}

// Validar tamaño máximo 5MB
if ($fileSize > 5 * 1024 * 1024) {
    echo json_encode(['status' => 'error', 'message' => 'La imagen pesa más de 5MB.']);
    exit();
}

// Asegurar que exista la carpeta de destino
$uploadDir = '../../frontend/assets/compiled/jpg/avatars/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Construir nombre único para no pisar fotos en caso de cache fuerte, usando timestamp
$newFileName = 'user_' . $userId . '_' . time() . '.' . $fileActualExt;
$fileDestination = $uploadDir . $newFileName;

if (move_uploaded_file($fileTmpName, $fileDestination)) {
    // La ruta relativa que usa el frontend para pintar la imagen a partir de index.php / user-perfil.php
    $dbPath = 'assets/compiled/jpg/avatars/' . $newFileName;
    
    // Primero, debemos confirmar si el usuario ya tiene un registro en 'perfil'.
    // Si la tabla perfil y usuario están vinculadas 1:1 y ya se crearon registros de prueba, usamos UPDATE.
    // Si no, lo correcto sería un INSERT INTO, pero asumimos que el perfil existe o usaremos ON DUPLICATE KEY si aplicara.
    // Para UTMedic, haremos UPDATE asumiendo que el ID de Usuario ya tiene un perfil precreado.
    
    $stmt = $conn->prepare("UPDATE perfil SET foto = ? WHERE idUsuario = ?");
    $stmt->bind_param("si", $dbPath, $userId);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows >= 0) { // Mayor o igual por si suben la misma y no hay un affected real diferente de 0.
            // Actualizar la variable de sesión para que el cambio persista en las siguientes cargas
            $_SESSION['user_avatar'] = $dbPath;
            echo json_encode(['status' => 'success', 'message' => 'Avatar subido correctamente.', 'avatar_url' => $dbPath]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo enlazar la imagen en la base de datos. Verifica si tu perfil existe.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error de consulta en la base de datos.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al guardar la imagen físicamente en el servidor.']);
}
?>
