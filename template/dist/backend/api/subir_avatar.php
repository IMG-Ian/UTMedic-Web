<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../frontend/user-perfil.php?error=" . urlencode('No autorizado. Por favor, inicie sesión.'));
    exit();
}

require_once '../config/conexion.php';

$userId = $_SESSION['user_id'];

// Revisar si se recibió el archivo
if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    header("Location: ../../frontend/user-perfil.php?error=" . urlencode('No se recibió ningún archivo o hubo un error en la subida.'));
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
    header("Location: ../../frontend/user-perfil.php?error=" . urlencode('Formato no soportado. Solo JPG, JPEG y PNG.'));
    exit();
}

// Validar tamaño máximo 5MB
if ($fileSize > 5 * 1024 * 1024) {
    header("Location: ../../frontend/user-perfil.php?error=" . urlencode('La imagen pesa más de 5MB.'));
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

    // El nuevo modelo reestructurado guarda la fotografía del perfil ahora en tabla `usuario` en el campo `foto_perfil`
    $stmt = $conn->prepare("UPDATE usuario SET foto_perfil = ? WHERE id_usuario = ?");
    $stmt->bind_param("si", $dbPath, $userId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows >= 0) { // Mayor o igual por si suben la misma y no hay un affected real diferente de 0.
            // Actualizar la variable de sesión para que el cambio persista en las siguientes cargas
            $_SESSION['user_avatar'] = $dbPath;
            header("Location: ../../frontend/user-perfil.php?success=avatar");
        } else {
            header("Location: ../../frontend/user-perfil.php?error=" . urlencode('No se pudo enlazar la imagen en la base de datos. Verifica si tu perfil existe.'));
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error de consulta en la base de datos.']);
        header("Location: ../../frontend/user-perfil.php?error=" . urlencode('Error de consulta en la base de datos.'));
    }
} else {
    header("Location: ../../frontend/user-perfil.php?error=" . urlencode('Error al guardar la imagen físicamente en el servidor.'));
}
?>