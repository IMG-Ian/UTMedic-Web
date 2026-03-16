<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'profesional') {
    echo json_encode(["status" => "error", "message" => "No autorizado. Su rol es: " . ($_SESSION['role'] ?? 'Ninguno')]);
    exit();
}

require_once '../config/conexion.php';

// Ocultar cualquier Warning HTML residual generado por PHP o mysqli para asegurar salida JSON limpia
ini_set('display_errors', 0);
error_reporting(0);

$userId = $_SESSION['user_id'];
$today = date('Y-m-d');

try {

// 1. Obtener ID del Profesional
$profStmt = $conn->prepare("SELECT id_profesional FROM profesional WHERE id_usuario = ?");
$profStmt->bind_param("i", $userId);
$profStmt->execute();
$profResult = $profStmt->get_result();

if ($profResult->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Perfil de médico no encontrado."]);
    exit();
}

$idProfesional = $profResult->fetch_assoc()['id_profesional'];

// 2. Citas del Día (Hoy)
$sqlDia = "
    SELECT 
        c.id_cita, 
        c.fecha, 
        c.hora, 
        CONCAT(u.nombre, ' ', u.apellido_pat) AS nombre_paciente
    FROM cita c
    INNER JOIN paciente p ON c.id_paciente = p.id_paciente
    INNER JOIN usuario u ON p.id_usuario = u.id_usuario
    WHERE c.id_profesional = ? 
      AND c.fecha = ?
      AND c.estado NOT IN ('cancelada', 'atendida', 'completada')
    ORDER BY c.hora ASC
";

$stmtDia = $conn->prepare($sqlDia);
$stmtDia->bind_param("is", $idProfesional, $today);
$stmtDia->execute();
$resDia = $stmtDia->get_result();

$citasDia = [];
while ($row = $resDia->fetch_assoc()) {
    $horaFormateada = date("h:i A", strtotime($row['hora']));
    $citasDia[] = [
        "id" => $row['id_cita'],
        "horario" => $horaFormateada,
        "paciente" => $row['nombre_paciente']
    ];
}

// 3. Citas Pendientes Totales
$sqlPendientes = "SELECT COUNT(*) as total FROM cita WHERE id_profesional = ? AND estado != 'cancelada' AND estado != 'atendida' AND fecha >= ?";
$stmtPen = $conn->prepare($sqlPendientes);
$stmtPen->bind_param("is", $idProfesional, $today);
$stmtPen->execute();
$totalPendientes = $stmtPen->get_result()->fetch_assoc()['total'];

// 4. Fechas de Citas para el Calendario (Futuras y Presentes)
$sqlCalendario = "SELECT DISTINCT fecha FROM cita WHERE id_profesional = ? AND estado != 'cancelada' AND fecha >= ?";
$stmtCal = $conn->prepare($sqlCalendario);
$stmtCal->bind_param("is", $idProfesional, $today);
$stmtCal->execute();
$resCal = $stmtCal->get_result();

$fechasCalendario = [];
while ($row = $resCal->fetch_assoc()) {
    $fechasCalendario[] = $row['fecha'];
}

// 5. Citas Atendidas Chart (Próximos 5 días con citas, aunque sean atendidas pasadas)
$sqlChart = "
    SELECT fecha, COUNT(*) as total_citas 
    FROM cita 
    WHERE id_profesional = ? 
      AND estado = 'atendida'
    GROUP BY fecha 
    ORDER BY fecha DESC 
    LIMIT 5
";
$stmtChart = $conn->prepare($sqlChart);
$stmtChart->bind_param("i", $idProfesional);
$stmtChart->execute();
$resChart = $stmtChart->get_result();

$chartLabelsTemp = [];
$chartSeriesTemp = [];
while ($row = $resChart->fetch_assoc()) {
    $chartLabelsTemp[] = date("d/m", strtotime($row['fecha']));
    $chartSeriesTemp[] = (int)$row['total_citas'];
}

// Invertir arrays para que el gráfico se lea cronológicamente
$chartLabels = array_reverse($chartLabelsTemp);
$chartSeries = array_reverse($chartSeriesTemp);

// Validar que la gráfica no esté vacía
if (count($chartLabels) == 0) {
    $chartLabels = [date("d/m")];
    $chartSeries = [0];
}

    $response = [
        "status" => "success",
        "data" => [
            "citasDia" => $citasDia,
            "totalPendientes" => $totalPendientes,
            "calendarioFechas" => $fechasCalendario,
            "chart" => [
                "labels" => $chartLabels,
                "series" => $chartSeries
            ]
        ]
    ];

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Error de BD: " . $e->getMessage()]);
}
?>
