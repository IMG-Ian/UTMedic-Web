<?php
// Configuración de rutas base para UTMedic-Web
// Este archivo centraliza las rutas para evitar rutas relativas rotas al mover archivos

// Ruta base del proyecto (desde donde se sirve, ej: /UTMedic-Web/template/dist)
define('BASE_URL', '/UTMedic-Web/template/dist');

// Rutas derivadas
define('FRONTEND_URL', BASE_URL . '/frontend');
define('BACKEND_URL', BASE_URL . '/backend');
define('API_URL', BASE_URL . '/backend/api');
define('ASSETS_URL', BASE_URL . '/frontend/assets');

// Rutas absolutas para archivos estáticos (útil si se mueve assets)
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