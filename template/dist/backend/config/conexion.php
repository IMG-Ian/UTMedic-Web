<?php
// backend/config/conexion.php

// Configuración básica de conexión a la Base de Datos MySQL
$host = "localhost";
$user = "root";
$password = "";
$database = "utmedic";

// Ocultar temporalmente los errores para garantizar que no impriman HTML y rompan el JSON
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('display_errors', 0);

// Intentar la conexión usando MySQLi, usamos @ para silenciar Warnings de PHP que escupen <br>
@$conn = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    // Si falla, se devuelve un error de texto puro y en formato JSON
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode(["status" => "error", "message" => "Conexión MySQL fallida: " . $conn->connect_error]);
    exit();
}

// Configurar charset a utf8
$conn->set_charset("utf8");

// Restaurar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
