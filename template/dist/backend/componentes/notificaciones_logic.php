<?php
// backend/componentes/notificaciones_logic.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/conexion.php';

$unreadCount = 0;
$unread_count = 0;
$notificacionesList = [];

// Asegurar que exista la sesión del usuario
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
    // Obtener notificaciones, ordenadas por fecha (más recientes primero)
    $sql = "SELECT id, titulo, mensaje, tipo, leida, fecha AS fecha_creacion FROM notificaciones WHERE usuario_id = ? ORDER BY fecha DESC";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        
        $count = 0;
        $toDelete = [];
        
        while ($row = $res->fetch_assoc()) {
            if ($count < 3) {
                $notificacionesList[] = $row;
                if ($row['leida'] == 0) {
                    $unreadCount++;
                }
            } else {
                // Si superan 3, lo marcamos para eliminar (Petición del usuario)
                $toDelete[] = $row['id'];
            }
            $count++;
        }
        
        $unread_count = $unreadCount;
        
        // Eliminar las notificaciones antiguas de la BD
        if (!empty($toDelete)) {
            $ids = implode(",", $toDelete);
            $conn->query("DELETE FROM notificaciones WHERE id IN ($ids)");
        }
    }
}
?>