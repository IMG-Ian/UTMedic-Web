<?php
// Configuración de rutas base para UTMedic-Web
// Este archivo auto-detecta la ruta base del proyecto para que funcione
// sin importar en qué carpeta se clone el repositorio.

// Auto-detectar la ruta base del proyecto
// Busca la carpeta "template/dist" dentro de DOCUMENT_ROOT para construir la URL
if (!defined('BASE_URL')) {
    $scriptPath = str_replace('\\', '/', __DIR__);
    $docRoot    = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? '');

    // __DIR__ apunta a backend/config/, subimos 2 niveles para llegar a template/dist
    $distDir = dirname(dirname($scriptPath)); // → .../template/dist
    $baseUrl = str_replace($docRoot, '', $distDir);

    define('BASE_URL', '/' . ltrim($baseUrl, '/'));
}

// Rutas derivadas
define('FRONTEND_URL', BASE_URL . '/frontend');
define('BACKEND_URL', BASE_URL . '/backend');
define('API_URL', BASE_URL . '/backend/api');
define('ASSETS_URL', BASE_URL . '/frontend/assets');

// Rutas absolutas para archivos estáticos
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/static/js');
define('IMG_URL', ASSETS_URL . '/static/images');

// Función helper para generar URLs absolutas
function getUrl($path) {
    return BASE_URL . '/' . ltrim($path, '/');
}

// Función helper para rutas del backend
function getBackendUrl($path) {
    return BACKEND_URL . '/' . ltrim($path, '/');
}

// Función helper para rutas de API
function getApiUrl($path) {
    return API_URL . '/' . ltrim($path, '/');
}
?>
