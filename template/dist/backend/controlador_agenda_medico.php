<?php
// backend/controlador_agenda_medico.php

// Asegurar que la sesión esté iniciada y el rol sea profesional
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'profesional') {
    header("Location: auth-login.php");
    exit();
}

require_once __DIR__ . '/config/conexion.php';

$userId = $_SESSION['user_id'];

// ---------------------------------------------------------
// Manejo de POST: Guardar Resultados de la Consulta Médica
// ---------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'finalizar_consulta') {
    $id_cita = intval($_POST['id_cita'] ?? 0);
    $diagnostico = $_POST['observaciones'] ?? $_POST['diagnostico_final'] ?? '';

    if ($id_cita > 0 && !empty($diagnostico)) {
        try {
            // Lógica corregida para mapear en notas_medicas en lugar de concatenarlo a la observación del paciente
            $stmtUpd = $conn->prepare("UPDATE cita SET estado = 'atendida', fecha_atencion = NOW(), notas_medicas = ? WHERE id_cita = ? AND id_profesional = (SELECT id_profesional FROM profesional WHERE id_usuario = ?)");
            $stmtUpd->bind_param("sii", $diagnostico, $id_cita, $userId);
            $stmtUpd->execute();

            // Notificación al paciente
            $stmtPac = $conn->prepare("SELECT p.id_usuario FROM cita c JOIN paciente p ON c.id_paciente = p.id_paciente WHERE c.id_cita = ?");
            $stmtPac->bind_param("i", $id_cita);
            if ($stmtPac->execute()) {
                $resPac = $stmtPac->get_result();
                if ($rowPac = $resPac->fetch_assoc()) {
                    $id_paciente_usuario = $rowPac['id_usuario'];
                    $titulo = "Consulta Finalizada";
                    $mensaje = "Tu consulta médica ha finalizado. El doctor ha guardado tu diagnóstico.";
                    $tipo = "completada";
                    $sqlN = "INSERT INTO notificaciones (usuario_id, titulo, mensaje, tipo) VALUES (?, ?, ?, ?)";
                    $stmtN = $conn->prepare($sqlN);
                    if ($stmtN) {
                        $stmtN->bind_param("isss", $id_paciente_usuario, $titulo, $mensaje, $tipo);
                        $stmtN->execute();
                    }
                }
            }

            header("Location: ../frontend/medico/medico-agenda.php?success=consulta_guardada");
            exit();
        } catch (Exception $e) {
            header("Location: ../frontend/medico/medico-agenda.php?error=guardar_consulta");
            exit();
        }
    } else {
        header("Location: ../frontend/medico/medico-agenda.php?error=datos_incompletos");
        exit();
    }
}

// ---------------------------------------------------------
// Lógica normal de GET: Obtener lista de citas
// ---------------------------------------------------------
$citasDelMedico = [];

try {
    // 1. Obtener ID del Profesional
    $profStmt = $conn->prepare("SELECT id_profesional FROM profesional WHERE id_usuario = ?");
    $profStmt->bind_param("i", $userId);
    $profStmt->execute();
    $profResult = $profStmt->get_result();

    if ($profResult->num_rows > 0) {
        $idProfesional = $profResult->fetch_assoc()['id_profesional'];

        // 2. Obtener todas las citas ordenadas por Pendientes primero
        $sql = "
            SELECT 
                c.id_cita, 
                c.id_paciente,
                c.fecha, 
                c.hora, 
                c.estado,
                c.observaciones AS motivo,
                COALESCE(NULLIF(TRIM(CONCAT_WS(' ', u.nombre, u.apellido_pat, u.apellido_mat)), ''), c.nombre_invitado, 'Invitado') as nombre_completo,
                p.matricula,
                p.alergias,
                p.padecimientos,
                u.foto_perfil
            FROM cita c
            LEFT JOIN paciente p ON c.id_paciente = p.id_paciente
            LEFT JOIN usuario u ON p.id_usuario = u.id_usuario
            WHERE c.id_profesional = ?
            ORDER BY 
                CASE WHEN c.estado = 'pendiente' OR c.estado = 'agendada' THEN 1 ELSE 2 END,
                c.fecha ASC, 
                c.hora ASC
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idProfesional);
        $stmt->execute();
        $result = $stmt->get_result();

        // 3. Obtener el historial de citas pasadas (Completadas/Atendidas) de este doctor
        $sqlHistorial = "
            SELECT id_paciente, fecha, observaciones
            FROM cita
            WHERE id_profesional = ? AND estado IN ('completada', 'atendida')
            ORDER BY fecha DESC, hora DESC
        ";
        $stmtH = $conn->prepare($sqlHistorial);
        $stmtH->bind_param("i", $idProfesional);
        $stmtH->execute();
        $resultH = $stmtH->get_result();

        $historialPorPaciente = [];
        while ($rowH = $resultH->fetch_assoc()) {
            $historialPorPaciente[$rowH['id_paciente']][] = $rowH;
        }

        while ($row = $result->fetch_assoc()) {
            $horaEmpezar = date("h:i A", strtotime($row['hora']));
            $horaTerminar = date("h:i A", strtotime($row['hora'] . " +1 hour"));

            $nombreCompleto = trim($row['nombre_completo']);
            $foto = !empty($row['foto_perfil']) ? htmlspecialchars($row['foto_perfil']) : 'assets/compiled/jpg/1.jpg';

            $citasDelMedico[] = [
                "id_cita" => $row['id_cita'],
                "id_paciente" => $row['id_paciente'],
                "fechaFormateada" => date("d M Y", strtotime($row['fecha'])),
                "horario" => "$horaEmpezar - $horaTerminar",
                "paciente" => htmlspecialchars($nombreCompleto),
                "matricula" => htmlspecialchars($row['matricula']),
                "alergias" => htmlspecialchars($row['alergias'] ?? 'Ninguna'),
                "padecimientos" => htmlspecialchars($row['padecimientos'] ?? 'Ninguno'),
                "estado" => strtolower($row['estado']),
                "motivo" => htmlspecialchars($row['motivo'] ?? 'Control de rutina'),
                "foto" => $foto
            ];
        }
    }
} catch (Exception $e) {
    // Fallo silencioso: $citasDelMedico quedará vacío y se pintará el empty state en la vista.
}

// ---------------------------------------------------------
// Obtener Pacientes para la modal de Walk-in
// ---------------------------------------------------------
$pacientesWalkin = [];
try {
    $stmtPacs = $conn->query("SELECT p.matricula, u.nombre, u.apellido_pat FROM paciente p INNER JOIN usuario u ON p.id_usuario = u.id_usuario");
    if ($stmtPacs && $stmtPacs->num_rows > 0) {
        while ($rPac = $stmtPacs->fetch_assoc()) {
            $pacientesWalkin[] = $rPac;
        }
    }
} catch (Exception $e) {
}
