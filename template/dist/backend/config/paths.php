<?php
// ========================================
// 🌐 DETECCIÓN AUTOMÁTICA DE BASE_URL
// ========================================

// Detectar protocolo (http o https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// Dominio (localhost o servidor uni)
$host = $_SERVER['HTTP_HOST'];

// 👉 Ajusta SOLO esta parte si cambia tu carpeta en servidor
$projectFolder = '/UTMedic-Web/template/dist';

// URL base final
define('BASE_URL', $protocol . $host . $projectFolder);


// ========================================
// 🌐 URLs (para navegador)
// ========================================

define('FRONTEND_URL', BASE_URL . '/frontend');
define('BACKEND_URL', BASE_URL . '/backend');
define('API_URL', BACKEND_URL . '/api');

define('ASSETS_URL', FRONTEND_URL . '/assets');
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/static/js');
define('IMG_URL', ASSETS_URL . '/static/images');


// ========================================
// 📁 PATHS (para PHP - require/include)
// ========================================

// Ruta física del proyecto en el servidor
define('ROOT_PATH', realpath(__DIR__ . '/../../'));

// Subrutas
define('BACKEND_PATH', ROOT_PATH . '/backend');
define('FRONTEND_PATH', ROOT_PATH . '/frontend');


// ========================================
// 🔧 HELPERS
// ========================================

// URLs
function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

function api($path = '') {
    return API_URL . '/' . ltrim($path, '/');
}

// PATHS (estos son los importantes para require_once)
function backend($path = '') {
    return BACKEND_PATH . '/' . ltrim($path, '/');
}

function frontend($path = '') {
    return FRONTEND_PATH . '/' . ltrim($path, '/');
}
?>