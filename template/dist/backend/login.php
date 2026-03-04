<?php

// Iniciar la sesión para poder guardar los datos del usuario logueado
session_start();

// Incluir el archivo de conexión a la base de datos
require_once 'api/conexion.php';

// Establecer cabeceras para permitir respuestas JSON, en caso de peticiones AJAX
header('Content-Type: application/json');

/**
 * Función para responder al cliente de manera estructurada en JSON y terminar la ejecución
 */
function sendResponse($status, $message, $redirectUrl = null) {
    echo json_encode(['status' => $status, 'message' => $message, 'redirect' => $redirectUrl]);
    exit();
}

/**
 * Flujo 1: Login a través de Google OAuth 2.0
 * Se verifica si se recibió 'credential' que es el JWT token provisto por Google.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['credential'])) {
    
    // El 'credential' es un JWT compuesto por header.payload.signature
    $id_token = $_POST['credential'];
    
    // Dividimos el JWT para obtener el Payload (la parte central)
    $jwt_parts = explode('.', $id_token);
    
    if (count($jwt_parts) === 3) {
        $payload = $jwt_parts[1];
        
        // El payload está codificado en Base64Url
        $decoded_payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $payload)), true);
        
        // Verificamos si la decodificación fue exitosa y tenemos un email
        if ($decoded_payload && isset($decoded_payload['email'])) {
            $email = $decoded_payload['email'];
            $name = $decoded_payload['name'] ?? 'Usuario Google';
            $google_id = $decoded_payload['sub']; // El ID único del usuario en Google
            
            // Temporalmente, como la BD no tiene columnas 'email' ni 'id_google' en la tabla 'usuario',
            // devolvemos un mensaje de error claro en vez de romper la ejecución de PHP.
            // Para activarlo 100%, se requiere agregar la columna 'email' y 'id_google' a la BD.
            sendResponse('error', 'El inicio de sesión mediante Google requiere que la Base de Datos tenga configurado el campo Correo Electrónico. Contacte al administrador.');
            
        } else {
            sendResponse('error', 'Token de Google inválido (Payload corrupto).');
        }
    } else {
        sendResponse('error', 'Formato de Token de Google incorrecto.');
    }
}

/**
 * Flujo 2: Login manual con Email/Matrícula y Contraseña
 */
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    
    $email_or_matricula = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (empty($email_or_matricula) || empty($password)) {
        sendResponse('error', 'Por favor, rellena todos los campos.');
    }
    
    // Hacemos LEFT JOIN con paciente únicamente para permitir el logueo usando la matrícula de paciente
    $sql = "
        SELECT u.id_usuario as id, u.nombre, u.apellido_pat, u.password, u.rol, u.estado, u.foto_perfil
        FROM usuario u
        LEFT JOIN paciente p ON u.id_usuario = p.id_usuario
        WHERE u.correo = ? OR p.matricula = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email_or_matricula, $email_or_matricula);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verificamos si la cuenta está inactiva (estado = 0)
        if ($user['estado'] != 1) {
            sendResponse('error', 'Tu cuenta se encuentra desactivada. Contacta al administrador.');
        }
        
        // La contraseña en BD se encuentra en texto plano según el análisis anterior
        if ($password === $user['password'] || password_verify($password, $user['password'])) {
            // Contraseña correcta, creamos la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'] . ' ' . $user['apellido_pat'];
            $_SESSION['role'] = $user['rol'];
            
            // Asignamos la foto encontrada en la base de datos o le damos una por defecto si está vacío
            $_SESSION['user_avatar'] = !empty($user['foto_perfil']) ? $user['foto_perfil'] : 'assets/compiled/jpg/1.jpg';
            
            // Redirección basada en el rol del usuario
            $redirectUrl = '../frontend/index.php'; // Por defecto (Paciente/Estudiante)
            switch (strtolower($user['rol'])) {
                case 'administrador':
                case 'admin':
                    $redirectUrl = '../frontend/dashboard-administrador.php';
                    break;
                case 'medico':
                case 'doctor':
                case 'profesional':
                    // Temporalmente enviamos a medico, pero deberemos crear un dashboard único o router 
                    // si un profesional puede ser psicologo o nutriologo basado en la tabla profesional.
                    $redirectUrl = '../frontend/dashboard-medico.php';
                    break;
            }
            
            sendResponse('success', 'Login exitoso', $redirectUrl);
        } else {
            // Contraseña incorrecta
            sendResponse('error', 'Contraseña incorrecta.');
        }
    } else {
        // Usuario no encontrado
        sendResponse('error', 'Usuario no encontrado. Verifica tu Correo o Matrícula.');
    }
} else {
    // Si la petición no es POST o no tiene los datos esperados
    sendResponse('error', 'Petición inválida.');
}
?>
