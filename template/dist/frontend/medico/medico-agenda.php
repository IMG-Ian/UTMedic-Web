<?php
header('Content-Type: text/html; charset=utf-8');
// Importar el escudo protector de rutas validando que sea Médico (Profesional en BD)
require_once __DIR__ . '/../../backend/auth_medico.php';
require_once __DIR__ . '/../../backend/config/paths.php';

$active_page = 'agenda';

// [BACKEND EXTERNO] Obtener Citas del Profesional logueado
require_once __DIR__ . '/../../backend/controlador_agenda_medico.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mazer Admin Dashboard</title>

    <link rel="shortcut icon"
        href="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2033%2034'%20fill-rule='evenodd'%20stroke-linejoin='round'%20stroke-miterlimit='2'%20xmlns:v='https://vecta.io/nano'%3e%3cpath%20d='M3%2027.472c0%204.409%206.18%205.552%2013.5%205.552%207.281%200%2013.5-1.103%2013.5-5.513s-6.179-5.552-13.5-5.552c-7.281%200-13.5%201.103-13.5%205.513z'%20fill='%23435ebe'%20fill-rule='nonzero'/%3e%3ccircle%20cx='16.5'%20cy='8.8'%20r='8.8'%20fill='%2341bbdd'/%3e%3c/svg%3e"
        type="image/x-icon">
    <link rel="shortcut icon"
        href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC"
        type="image/png">


    <link rel="stylesheet" crossorigin href="./assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/iconly.css">
        <link rel="stylesheet" href="assets/css/utmedic-global.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/utmedic-dashboard.css?v=<?= time() ?>">
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative px-4 py-3">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="logo align-items-center d-flex mb-0">
                            <a href="medico/dashboard-medico.php" class="text-decoration-none">
                                <h3 class="mb-0 fw-bold" style="color: var(--utm-accent) !important; letter-spacing: 1px;">UTMedic</h3>
                            </a>
                        </div>
                        <div class="theme-toggle d-flex gap-2 align-items-center mb-0">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                    style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20"
                                preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menú Principal</li>

                        <li class="sidebar-item <?= strpos(basename($_SERVER['PHP_SELF']), 'dashboard-') !== false ? 'active' : '' ?>">
                            <a href="dashboard-<?= isset($_SESSION['especialidad']) ? (strpos(strtolower($_SESSION['especialidad']), 'nutri') !== false ? 'nutricionista' : (strpos(strtolower($_SESSION['especialidad']), 'psicolo') !== false ? 'psicologo' : 'medico')) : 'medico' ?>.php" class="sidebar-link">
                                <i class="bi bi-house-door-fill"></i>
                                <span>Inicio</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'medico-agenda.php' ? 'active' : '' ?>">
                            <a href="medico/medico-agenda.php" class="sidebar-link">
                                <i class="bi bi-calendar-check-fill"></i>
                                <span>Agenda de Citas</span>
                            </a>
                        </li>



                        <?php if (!isset($_SESSION["especialidad"]) || strpos(strtolower($_SESSION["especialidad"]), "medico") !== false): ?>
<li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'medico-emergencia.php' ? 'active' : '' ?>">
                            <a href="medico-emergencia.php" class="sidebar-link">
                                <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                                <span>Emergencia</span>
                            </a>
                        </li>
<?php endif; ?>

                        <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'shared/user-perfil.php' ? 'active' : '' ?>">
                            <a href="shared/user-perfil.php" class="sidebar-link">
                                <i class="bi bi-person-circle"></i>
                                <span>Perfil</span>
                            </a>
                        </li>
                        
                        <!-- Cierre de sesión -->
                        <li class="sidebar-item mt-5 pt-3 border-top">
                            <a href="<?= BACKEND_URL ?>/logout.php" class="sidebar-link text-danger">
                                <i class="bi bi-box-arrow-left text-danger"></i>
                                <span>Cerrar Sesión</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Panel <?php echo (isset($_SESSION['especialidad']) && strpos(strtolower($_SESSION['especialidad']), 'nutriolog') !== false) ? 'de Nutriología' : ((isset($_SESSION['especialidad']) && strpos(strtolower($_SESSION['especialidad']), 'psicolog') !== false) ? 'de Psicología' : 'del Médico'); ?></h3>
                    <div class="d-flex align-items-center gap-3">
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalWalkIn" style="border-radius: 50px; font-weight: bold;"><i class="bi bi-calendar-plus me-2"></i>Agendar Walk-in</button>
                                                
                        <?php require_once '../backend/componentes/notificaciones_logic.php'; ?>
                        <div class="dropdown">
                            <a href="#" class="position-relative text-decoration-none" data-bs-toggle="dropdown" id="notifDropdownToggle" aria-expanded="false">
                                <i class="bi bi-bell-fill fs-4 text-muted"></i>
                                <?php if(isset($unreadCount) && $unreadCount > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;"><?= $unreadCount ?></span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="dropdownMenuButton" style="width: 300px; padding: 10px; max-height: 400px; overflow-y: auto; overflow-x: hidden;">
                                <li>
                                    <h6 class="dropdown-header font-bold text-dark d-flex justify-content-between align-items-center pb-2">
                                        Notificaciones
                                    </h6>
                                </li>
                                <?php if(empty($notificacionesList)): ?>
                                    <li><div class="dropdown-item text-muted text-center py-4" style="font-size: 0.9rem; white-space: normal;">No tienes notificaciones recientes.</div></li>
                                <?php else: ?>
                                    <?php foreach($notificacionesList as $notif): 
                                        $icon = 'bi-info-circle';
                                        $bgClass = 'bg-secondary';
                                        if($notif['tipo'] === 'nueva_cita') { $icon = 'bi-calendar-plus'; $bgClass = 'bg-primary'; }
                                        if($notif['tipo'] === 'cancelacion') { $icon = 'bi-calendar-x'; $bgClass = 'bg-danger'; }
                                        if($notif['tipo'] === 'completada') { $icon = 'bi-check-circle'; $bgClass = 'bg-success'; }
                                        
                                        $opacity = $notif['leida'] == 0 ? '1' : '0.7';
                                        $fontWeight = $notif['leida'] == 0 ? 'font-bold text-dark' : 'text-muted fw-semibold';
                                    ?>
                                    <li>
                                        <div class="dropdown-item d-flex align-items-start py-3 rounded mt-1 border-bottom" style="white-space: normal; opacity: <?= $opacity ?>; min-width: 280px; text-decoration: none;">
                                            <div class="<?= $bgClass ?> text-white rounded-circle me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; font-size: 1.25rem;">
                                                <i class="bi <?= $icon ?>" style="line-height: 0;"></i>
                                            </div>
                                            <div style="min-width: 0; flex: 1;">
                                                <h6 class="mb-1 text-sm <?= $fontWeight ?>" style="white-space: normal; word-wrap: break-word; line-height: 1.3;"><?= htmlspecialchars($notif['titulo']) ?></h6>
                                                <p class="mb-1 text-xs text-muted" style="font-size: 0.8rem; white-space: normal; word-wrap: break-word; line-height: 1.4;"><?= htmlspecialchars($notif['mensaje']) ?></p>
                                                <small class="text-muted d-block mt-1" style="font-size: 0.7rem; font-weight: 500;"><?= date('d M Y H:i', strtotime($notif['fecha_creacion'])) ?></small>
                                            </div>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <a href="shared/user-perfil.php" class="text-decoration-none d-flex align-items-center top-nav-profile-container" style="background: rgba(0,0,0,0.03); padding: 5px 15px; border-radius: 50px; border: 1px solid rgba(0,0,0,0.05); cursor: pointer;">
                            <div class="avatar avatar-sm border border-2 border-primary d-flex align-items-center justify-content-center overflow-hidden" style="background: white; border-radius: 50%; min-width: 32px; min-height: 32px;">
                                <img src="<?= htmlspecialchars($_SESSION['user_avatar'] ?? 'assets/compiled/jpg/1.jpg') ?>" id="top-nav-avatar" alt="Avatar" style="width: 32px; height: 32px; object-fit: cover;">
                            </div>
                            <div class="ms-2">
                                <h6 class="mb-0 fs-6 user-name-display text-dark opacity-100"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Médico') ?></h6>
                                <p class="mb-0 text-muted" style="font-size: 0.75rem;">Profesional</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <!-- Título y Filtros Rapidos -->
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-bold text-dark mb-1">Próximas Citas</h4>
                                <p class="text-muted mb-0" style="font-size: 0.9rem;">Revisa y administra tus citas programadas</p>
                            </div>
                            
                            <div class="mt-3 mt-md-0 d-flex gap-2 nav-pills-custom">
                                <button class="btn btn-sm px-4 py-2 rounded-pill active shadow-sm" style="background-color: var(--utm-secondary); color: white; border: none; font-weight: 600;">Todos</button>
                                <button class="btn btn-sm px-4 py-2 rounded-pill shadow-sm bg-white text-secondary border border-light" style="font-weight: 600;">Pendientes</button>
                                <button class="btn btn-sm px-4 py-2 rounded-pill shadow-sm bg-white text-secondary border border-light" style="font-weight: 600;">Completadas</button>
                                <button class="btn btn-sm px-4 py-2 rounded-pill shadow-sm bg-white text-secondary border border-light" style="font-weight: 600;">Canceladas</button>
                            </div>
                        </div>

                        <!-- Contenedor Lista de Citas (Renderizado PHP NATIVO) -->
                        <div class="citas-list-container" id="agenda-container">
                            
                            <?php
if (empty($citasDelMedico)): ?>
                                <!-- Empty State -->
                                <div class="text-center py-5 shadow-sm" style="border-radius: 12px; border: 1px dashed var(--bs-border-color); background-color: var(--bs-body-bg);">
                                    <i class="bi bi-calendar2-x text-muted opacity-50 mb-3" style="font-size: 3rem;"></i>
                                    <h5 class="text-muted">No hay citas registradas en tu agenda</h5>
                                    <p class="text-sm text-secondary">Aún no se te han asignado pacientes.</p>
                                </div>
                            <?php
else: ?>
                                
                                <?php
foreach($citasDelMedico as $cita): 
                                    // Lógica de Clasificación de Estados
                                    $estado = $cita['estado'];
                                    $isAtendidaOCancelada = in_array($estado, ['atendida', 'completada', 'cancelada']);
                                    $isPendiente = in_array($estado, ['pendiente', 'confirmada', 'agendada']);
                                    
                                    // Clases dinámicas CSS dependiendo del estado
                                    $indicatorColor = 'bg-info';
                                    $opacityClass = '';
                                    $filterStyle = '';
                                    $clockColor = 'text-dark';
                                    
                                    // Separación de filtros
                                    if ($isPendiente) {
                                        $filtroJSClass = 'cita-pendiente';
                                    } else if ($estado === 'cancelada') {
                                        $filtroJSClass = 'cita-cancelada';
                                    } else {
                                        $filtroJSClass = 'cita-completada';
                                    }
                                    
                                    if ($isAtendidaOCancelada) {
                                        $indicatorColor = ($estado === 'cancelada') ? 'bg-danger' : 'bg-primary';
                                        $opacityClass = 'opacity-75';
                                        $filterStyle = 'filter: grayscale(50%);';
                                        $textStyle = 'text-decoration-line-through text-muted';
                                        $clockColor = 'text-muted';
                                    }
                                ?>
                                <!-- Tarjeta de Paciente (HTML Nativo PHP) -->
                                <div class="card shadow-sm border-0 mb-3 cita-card position-relative overflow-hidden <?= $opacityClass ?> <?= $filtroJSClass ?>" style="border-radius: 12px; transition: all 0.2s; <?= $filterStyle ?>">
                                    <div class="position-absolute top-0 bottom-0 start-0 <?= $indicatorColor ?>" style="width: 6px;"></div>
                                    <div class="card-body p-4 ms-2">
                                        <div class="row align-items-center">
                                            
                                            <!-- Columna de Datos de Paciente -->
                                            <div class="col-12 col-md-4 d-flex align-items-center mb-3 mb-md-0">
                                                <div class="avatar avatar-md bg-light me-3 p-1 rounded-circle shadow-sm border">
                                                    <img src="<?= $cita['foto'] ?>" alt="Paciente" style="object-fit:cover;" onerror="this.src='assets/compiled/jpg/1.jpg'">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold <?= $textStyle ?>"><?= $cita['paciente'] ?></h6>
                                                    <span class="badge bg-light text-secondary border mt-1" style="font-size: 0.7rem;">Matricula: <?= $cita['matricula'] ?></span>
                                                    <div class="text-secondary mt-1" style="font-size: 0.75rem;"><i class="bi bi-calendar2-minus"></i> <?= $cita['fechaFormateada'] ?></div>
                                                </div>
                                            </div>

                                            <!-- Columna de Motivos -->
                                            <div class="col-12 col-md-5 mb-3 mb-md-0 d-flex flex-column justify-content-center">
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="bi bi-clock-fill text-muted me-2" style="font-size: 0.85rem;"></i>
                                                    <span class="fw-bold <?= $clockColor ?>" style="font-size: 0.95rem;"><?= $cita['horario'] ?></span>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-chat-left-text-fill text-muted me-2" style="font-size: 0.85rem;"></i>
                                                    <span class="text-secondary text-truncate" style="font-size: 0.85rem; max-width: 250px;" title="<?= $cita['motivo'] ?>"><?= $cita['motivo'] ?></span>
                                                </div>
                                            </div>

                                            <!-- Columna de Acciones de Tarjeta -->
                                            <div class="col-12 col-md-3 d-flex flex-column align-items-md-end justify-content-center">
                                                <?php
if($isAtendidaOCancelada): ?>
                                                    <?php
                                                        if (strtolower($estado) === 'cancelada') {
                                                            $badgeClasses = 'bg-danger bg-opacity-10 border border-danger text-danger';
                                                        } elseif (strtolower($estado) === 'completada' || strtolower($estado) === 'atendida') {
                                                            $badgeClasses = 'bg-secondary text-white border-0';
                                                        } else {
                                                            $badgeClasses = 'bg-info bg-opacity-10 border border-info text-dark';
                                                        }
                                                        $label = ucfirst($estado);
                                                    ?>
                                                    <span class="badge rounded-pill mb-2 px-3 py-1 <?= $badgeClasses ?>"><?= $label ?></span>
                                                    <div class="d-flex gap-3 align-items-center">
                                                        <button onclick="verDetalles(this)" 
                                                                data-id="<?= $cita['id_cita'] ?>"
                                                                data-fecha="<?= $cita['fechaFormateada'] ?>"
                                                                data-hora="<?= $cita['horario'] ?>"
                                                                data-estado="<?= ucfirst($estado) ?>"
                                                                data-motivo="<?= htmlspecialchars($cita['motivo']) ?>"
                                                                data-paciente="<?= htmlspecialchars($cita['paciente']) ?>"
                                                                class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center p-0 border" style="width: 38px; height: 38px;" title="Ver Detalles">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                        </button>
                                                    </div>

                                                <?php
else: ?>
                                                    
                                                    <?php
$badgeLabel = empty($estado) ? 'Pendiente' : ucfirst($estado); ?>
                                                    <span class="badge rounded-pill bg-info text-dark mb-2 px-3 py-1 bg-opacity-25 border border-info"><?= $badgeLabel ?></span>
                                                    <div class="d-flex gap-3 align-items-center">
                                                        <button onclick="verDetalles(this)" 
                                                                data-id="<?= $cita['id_cita'] ?>"
                                                                data-fecha="<?= $cita['fechaFormateada'] ?>"
                                                                data-hora="<?= $cita['horario'] ?>"
                                                                data-estado="<?= ucfirst($estado) ?>"
                                                                data-motivo="<?= htmlspecialchars($cita['motivo']) ?>"
                                                                data-paciente="<?= htmlspecialchars($cita['paciente']) ?>"
                                                                class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center p-0 border" style="width: 38px; height: 38px;" title="Ver Detalles">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                        </button>
                                                        <button onclick="cancelarCita(<?= $cita['id_cita'] ?>)" class="btn btn-outline-danger rounded-circle d-flex align-items-center justify-content-center p-0 border" style="width: 38px; height: 38px;" title="Cancelar Cita">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                        </button>
                                                        <button onclick="abrirModalConsulta(this)" 
                                                                data-id="<?= $cita['id_cita'] ?>"
                                                                data-nombre="<?= htmlspecialchars($cita['paciente']) ?>"
                                                                data-matricula="<?= htmlspecialchars($cita['matricula']) ?>"
                                                                data-alergias="<?= htmlspecialchars($cita['alergias'] ?? 'Ninguna') ?>"
                                                                data-padecimientos="<?= htmlspecialchars($cita['padecimientos'] ?? 'Ninguno') ?>"
                                                                data-motivo="<?= htmlspecialchars($cita['motivo']) ?>"
                                                                class="btn btn-sm text-white rounded-pill px-4 shadow-sm fw-bold ms-1" style="background-color: #018790; height: 38px;" title="Comenzar Consulta">
                                                            Atender
                                                        </button>
                                                    </div>

                                                <?php
endif; ?>
                                                
                                                <!-- Contenedor Oculto con Historial Previo para enviarlo al Modal -->
                                                <div id="historial-data-<?= $cita['id_cita'] ?>" class="d-none">
                                                    <?php
                                                    $pastCitas = $historialPorPaciente[$cita['id_paciente']] ?? [];
                                                    if (empty($pastCitas)): ?>
                                                        <div class="text-center text-muted py-4">
                                                            <i class="bi bi-clock-history opacity-50 mb-2 d-block" style="font-size: 2rem;"></i>
                                                            <p class="mb-0" style="font-size:0.85rem;">No hay consultas previas con este paciente en tu registro.</p>
                                                        </div>
                                                    <?php
else: ?>
                                                        <div class="list-group list-group-flush text-start">
                                                        <?php
foreach($pastCitas as $pc): 
                                                            $fechaPasada = date("d/m/Y", strtotime($pc['fecha']));
                                                        ?>
                                                            <div class="list-group-item bg-transparent px-3 py-3 border-bottom border-light">
                                                                <div class="d-flex w-100 justify-content-between mb-1">
                                                                    <small class="fw-bold text-dark"><i class="bi bi-calendar2-check text-primary me-2"></i>Consulta del <?= $fechaPasada ?></small>
                                                                </div>
                                                                <p class="mb-0 text-secondary" style="font-size: 0.8rem; line-height: 1.4; border-left: 3px solid #ced4da; padding-left: 10px;"><?= nl2br(htmlspecialchars($pc['observaciones'])) ?></p>
                                                            </div>
                                                        <?php
endforeach; ?>
                                                        </div>
                                                    <?php
endif; ?>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php
endforeach; ?>

                            <?php
endif; ?>
                            
                        </div> <!-- fin lista -->
                    </div>
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted pb-4">
                    <div class="float-start">
                        <p>2024 &copy; UTMedic</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="assets/static/js/components/dark.js"></script>
    <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>


    <script src="assets/compiled/js/app.js"></script>
    <script src="assets/extensions/sweetalert2/sweetalert2.min.js"></script>

    <!-- Modal Ver Detalles de Cita (Botón Ojo) -->
    <div class="modal fade" id="modalVerDetalles" tabindex="-1" aria-labelledby="modalVerDetallesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark fs-5" id="modalVerDetallesLabel"><i class="bi bi-calendar2-check text-primary me-2"></i> Detalles de la Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-3 pb-4 px-4">
                    <div class="d-flex justify-content-end mb-3">
                        <span id="detalleModal_estado" class="badge bg-secondary rounded-pill px-3 py-2"></span>
                    </div>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <div class="d-flex align-items-center p-3 rounded bg-light border">
                                <i class="bi bi-person-circle fs-3 text-secondary me-3"></i>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">Paciente</small>
                                    <span class="fw-bold text-dark" id="detalleModal_paciente"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded border text-center h-100">
                                <i class="bi bi-calendar-event text-primary mb-2 fs-5"></i>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Fecha</small>
                                <span class="fw-bold text-dark" id="detalleModal_fecha" style="font-size: 0.9rem;"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded border text-center h-100">
                                <i class="bi bi-clock text-primary mb-2 fs-5"></i>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Horario</small>
                                <span class="fw-bold text-dark" id="detalleModal_hora" style="font-size: 0.9rem;"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Caja de Motivo / Diagnóstico -->
                    <div class="bg-white rounded border p-3 border-start border-4 border-info shadow-sm">
                         <div id="detalleModal_motivo" class="text-dark" style="font-size: 0.9rem;"></div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center pt-0 pb-4">
                     <button type="button" class="btn btn-primary px-5 rounded-pill shadow-sm" style="background-color: #018790; border:none;" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal Detalles -->


    <script>
        // Constantes de rutas desde PHP
        const BACKEND_URL = '<?= BACKEND_URL ?>';
        const API_URL = '<?= API_URL ?>';

        document.addEventListener('DOMContentLoaded', function() {
            // Lógica de filtrado de pastillas (Manejo de display CSS Local)
            const filterBtns = document.querySelectorAll('.nav-pills-custom .btn');
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Resetear estilos visuales de TODOS los botones a su estado inactivo
                    filterBtns.forEach(b => {
                        b.classList.remove('active', 'text-white');
                        b.classList.add('bg-white', 'text-secondary', 'border', 'border-light');
                        b.style.backgroundColor = ''; // Limpiar inline
                    });
                    
                    // Colorear SOLO el botón al que se le hizo clic
                    this.classList.remove('bg-white', 'text-secondary', 'border', 'border-light');
                    this.classList.add('active', 'text-white');
                    this.style.backgroundColor = 'var(--utm-secondary)';
                    this.style.border = 'none';

                    // Obtener intención de filtrado
                    const filtro = this.textContent.trim().toLowerCase();
                    filtrarCitasNativo(filtro);
                });
            });
            
            // Forzar disparo inicial por seguridad (opcional, todos)
            // filtrarCitasNativo('todos'); 
        });

        function filtrarCitasNativo(filtro) {
            const tarjetas = document.querySelectorAll('.cita-card');
            let visibles = 0;
            
            // Aplicar el filtro a las tarjetas y contar cuántas sobreviven
            tarjetas.forEach(tarjeta => {
                tarjeta.classList.remove('d-none');
                
                if (filtro === 'pendientes') {
                    if (!tarjeta.classList.contains('cita-pendiente')) {
                        tarjeta.classList.add('d-none');
                    } else {
                        visibles++;
                    }
                } else if (filtro === 'completadas') {
                    if (!tarjeta.classList.contains('cita-completada')) {
                        tarjeta.classList.add('d-none');
                    } else {
                        visibles++;
                    }
                } else if (filtro === 'canceladas') {
                    if (!tarjeta.classList.contains('cita-cancelada')) {
                        tarjeta.classList.add('d-none');
                    } else {
                        visibles++;
                    }
                } else {
                    visibles++;
                }
            });

            // Lógica de Empty State
            let emptyState = document.getElementById('empty-state-filtro');
            
            if (visibles === 0) {
                if(!emptyState) {
                    // Inyectar en #agenda-container (asegurando el id correcto)
                    const htmlVacio = `
                        <div id="empty-state-filtro" class="text-center py-5 bg-white shadow-sm mt-3" style="border-radius: 12px; border: 1px dashed #ced4da;">
                            <i class="bi bi-cup-hot text-muted opacity-50 mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-muted">No hay citas en esta categoría</h5>
                            <p class="text-sm text-secondary">Intente seleccionando otro filtro o tómese un descanso.</p>
                        </div>
                    `;
                    document.getElementById('agenda-container').insertAdjacentHTML('beforeend', htmlVacio);
                } else {
                    emptyState.classList.remove('d-none');
                }
            } else {
                if (emptyState) emptyState.classList.add('d-none');
            }
        }

        // Funciones de Acción
        function verDetalles(btnElement) {
            // Leer atributos del botón
            const id = btnElement.getAttribute('data-id');
            const fecha = btnElement.getAttribute('data-fecha');
            const hora = btnElement.getAttribute('data-hora');
            const estado = btnElement.getAttribute('data-estado');
            const paciente = btnElement.getAttribute('data-paciente');
            const motivo = btnElement.getAttribute('data-motivo');

            // Setear en el modal

            document.getElementById('detalleModal_fecha').textContent = fecha;
            document.getElementById('detalleModal_hora').textContent = hora;
            document.getElementById('detalleModal_paciente').textContent = paciente;
            
            // Color de estado
            const badgeEstado = document.getElementById('detalleModal_estado');
            badgeEstado.textContent = estado;
            badgeEstado.className = 'badge rounded-pill px-3 py-2';
            if(estado.toLowerCase() === 'pendiente' || estado.toLowerCase() === 'agendada') badgeEstado.classList.add('bg-info', 'text-dark');
            else if(estado.toLowerCase() === 'cancelada') badgeEstado.classList.add('bg-danger', 'text-white');
            else badgeEstado.classList.add('bg-secondary', 'text-white');

            // Separar notas "Diagnóstico Médico Final" si la cita ya fue atendida
            const observacionBox = document.getElementById('detalleModal_motivo');
            if(motivo.includes('--- Diagnóstico Médico Final ---')) {
                const parts = motivo.split('--- Diagnóstico Médico Final ---');
                let htmlFormat = `<div border-start border-3 border-primary ps-2 mb-3"><strong class='text-muted d-block'>Motivo Inicial:</strong> ${parts[0].trim() || 'No especificado'}</div>`;
                htmlFormat += `<div class="bg-light p-3 rounded border border-success border-opacity-25" style="white-space: pre-wrap;"><strong class='text-primary d-block mb-1'><i class="bi bi-file-medical text-primary me-1"></i>Diagnóstico Médico:</strong>${parts[1].trim()}</div>`;
                observacionBox.innerHTML = htmlFormat;
            } else {
                observacionBox.innerHTML = `<strong class='text-muted d-block'>Observaciones / Motivo:</strong><span style="white-space: pre-wrap;">${motivo || 'Ninguna observación registrada'}</span>`;
            }

            // Mostrar Modal
            const detalleModal = new bootstrap.Modal(document.getElementById('modalVerDetalles'));
            detalleModal.show();
        }

        function abrirModalConsulta(btnElement) {
            // Leer la data de los atributos del boton
            const idCita = btnElement.getAttribute('data-id');
            const nombre = btnElement.getAttribute('data-nombre');
            const matricula = btnElement.getAttribute('data-matricula');
            const alergias = btnElement.getAttribute('data-alergias');
            const padecimientos = btnElement.getAttribute('data-padecimientos');
            const motivo = btnElement.getAttribute('data-motivo');
            
            // Obtener el HTML precargado del Historial
            const historyHtml = document.getElementById('historial-data-' + idCita).innerHTML;
            
            // Llenar el modal con los datos
            document.getElementById('modalConsulta_id').value = idCita;
            document.getElementById('modalConsulta_nombre').textContent = nombre;
            document.getElementById('modalConsulta_matricula').textContent = matricula;
            document.getElementById('modalConsulta_alergias').textContent = alergias;
            document.getElementById('modalConsulta_padecimientos').textContent = padecimientos;
            document.getElementById('modalConsulta_motivo').textContent = motivo;
            
            // Inyectar el historial Médico Pasado
            document.getElementById('modalConsulta_historialContent').innerHTML = historyHtml;
            
            // Inicializar el modal de Bootstrap y Mostrarlo
            const modalConsulta = new bootstrap.Modal(document.getElementById('modalAtenderCita'));
            modalConsulta.show();
        }

        function cancelarCita(idCita) {
            Swal.fire({
                title: '¿Cancelar cita?',
                text: "El paciente será notificado de la cancelación.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, cancelar cita',
                cancelButtonText: 'No, mantener'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${API_URL}/cancelar_cita_medico.php`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'id_cita=' + idCita
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                title: 'Cancelada',
                                text: 'La cita ha sido cancelada correctamente.',
                                icon: 'success',
                                confirmButtonColor: '#018790'
                            }).then(() => {
                                window.location.reload(); // Recargar PHP nativo
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Error al cancelar la cita', 'error');
                        }
                    })
                    .catch(e => {
                        console.error(e);
                        Swal.fire('Error de red', 'No pudimos contactar con el sistema central', 'error');
                    });
                }
            });
        }
    </script>
    <!-- SweetAlert2 para Notificaciones bonitas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/static/js/pages/dashboard.js"></script>

    <style>
        .cita-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
        .nav-pills-custom .btn {
            transition: all 0.3s ease;
        }
        .nav-pills-custom .btn:hover {
            background-color: rgba(26, 155, 142, 0.1) !important;
            color: #018790 !important;
        }
    </style>
    <!-- Modal Atender Cita (Reemplazo de redirección manual) -->
    <div class="modal fade" id="modalAtenderCita" tabindex="-1" aria-labelledby="modalAtenderCitaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; background-color: var(--bs-body-bg);">
                <div class="modal-header border-bottom-0 pb-0" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: transparent;">
                    <h5 class="modal-title fw-bold w-100 fs-5 text-center" id="modalAtenderCitaLabel">Atender Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="<?= BACKEND_URL ?>/controlador_agenda_medico.php" method="POST">
                    <!-- Envio del ID Oculto para UPDATE la Base de Datos -->
                    <input type="hidden" name="id_cita" id="modalConsulta_id" value="">
                    <!-- Parametro para que el backend sepa que hacer -->
                    <input type="hidden" name="accion" value="finalizar_consulta">
                    
                    <div class="modal-body p-4 pt-3">
                        <div class="row g-4">
                            <!-- Columna Izquierda: Datos Constantes del Paciente -->
                            <div class="col-12 col-md-5 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm" style="border-radius: 10px; background-color: var(--bs-tertiary-bg);">
                                    <div class="card-body text-center p-4">
                                        <h6 class="fw-bold mb-4 text-center" style="font-size: 1.1rem;">Paciente Detalles</h6>
                                        
                                        <div class="avatar avatar-xl bg-white mb-4 p-1 shadow-sm mx-auto" style="width: 100px; height: 100px;">
                                            <img src="assets/compiled/jpg/1.jpg" alt="Foto Paciente" style="object-fit:cover; width: 100%; height: 100%;">
                                        </div>
                                        
                                        <div class="text-center mt-3 px-2" style="font-size: 0.9rem;">
                                            <p class="mb-3"><span class="text-muted fw-bold d-block" style="font-size: 0.75rem;">Motivo de la Cita:</span> <span id="modalConsulta_motivo"></span></p>
                                            <p class="mb-3"><span class="text-muted fw-bold d-block" style="font-size: 0.75rem;">Nombre Completo</span> <span id="modalConsulta_nombre"></span></p>
                                            <p class="mb-3"><span class="text-muted fw-bold d-block" style="font-size: 0.75rem;">Matricula</span> <span id="modalConsulta_matricula"></span></p>
                                            <p class="mb-3"><span class="text-muted fw-bold d-block" style="font-size: 0.75rem;">Alergias Relevantes:</span> <span id="modalConsulta_alergias" class="fw-semibold"></span></p>
                                            <p class="mb-3"><span class="text-muted fw-bold d-block" style="font-size: 0.75rem;">Padecimientos Crónicos:</span> <span id="modalConsulta_padecimientos"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Columna Derecha: Formulario Final -->
                            <div class="col-12 col-md-7 col-lg-8">
                                <div class="card h-100 border-0 shadow-sm" style="border-radius: 10px; background-color: var(--bs-secondary-bg);">
                                    <div class="card-body p-4 d-flex flex-column">
                                        
                                        <!-- Historial Médico Pasado (Reemplazo de Signos) -->
                                        <div class="mb-3 bg-white rounded p-3 text-start border shadow-sm mx-0 d-flex flex-column" style="height: 250px;">
                                            <h6 class="fw-bold text-dark mb-2 w-100" style="font-size: 0.85rem;">
                                                <i class="bi bi-clock-history text-primary me-2"></i> Historial Previo con este Paciente
                                            </h6>
                                            <div id="modalConsulta_historialContent" class="overflow-auto flex-grow-1 bg-light rounded shadow-inner" style="border: 1px solid #e9ecef;">
                                                <!-- El JavaScript copia en caliente el historial de la tarjeta aca -->
                                            </div>
                                        </div>
                                        
                                        <!-- Textarea Real del Médico -->
                                        <textarea class="form-control mb-3 flex-grow-1 shadow-sm" name="diagnostico_final" placeholder="Escribe aquí tu diagnóstico, recetas o indicaciones finales..." style="resize: none; min-height: 120px; border:2px solid #6c757d;" required></textarea>
                                        
                                        <!-- Botón de Envío -->
                                        <div class="text-end mt-auto">
                                            <button type="submit" class="btn text-white px-4 py-2 mt-2" style="background-color: #018790; border-radius: 6px; font-weight: 500;">Finalizar Consulta</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fin Modal -->

    

    <!-- Modal Walk-In -->
    <div class="modal fade" id="modalWalkIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; background-color: var(--bs-body-bg);">
                <div class="modal-header bg-transparent border-bottom-0 pb-0" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="modal-title fw-bold text-dark px-2 pt-2">Agendar Cita Presencial (Walk-In)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formWalkIn">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Tipo de Paciente</label>
                                <select class="form-select" id="tipoPaciente" style="border-radius: 8px;">
                                    <option value="invitado" selected>Invitado (Sin Perfil)</option>
                                    <option value="existente">Paciente Existente</option>
                                </select>
                            </div>
                            
                            <div class="col-12" id="divNombreInvitado">
                                <label class="form-label fw-bold">Nombre del Paciente <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre_invitado" id="nombre_invitado" placeholder="Juan Pérez" style="border-radius: 8px;" required>
                            </div>

                            <div class="col-12 d-none" id="divPacienteExistente">
                                <label class="form-label fw-bold">Buscar Paciente Existente <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="matricula_paciente" id="matricula_paciente" list="pacientesWalkinList" placeholder="Escribe el nombre o matrícula..." style="border-radius: 8px;" autocomplete="off">
                                <datalist id="pacientesWalkinList">
                                    <?php
                                    if(isset($conn)){
                                        $stmtPacs = $conn->query("SELECT p.matricula, u.nombre, u.apellido_pat FROM paciente p INNER JOIN usuario u ON p.id_usuario = u.id_usuario");
                                        if ($stmtPacs && $stmtPacs->num_rows > 0) {
                                            while($rPac = $stmtPacs->fetch_assoc()) {
                                                $n = htmlspecialchars(trim($rPac['nombre'] . ' ' . $rPac['apellido_pat']));
                                                $m = htmlspecialchars($rPac['matricula']);
                                                echo "<option value=\"$m\">$n - Matrícula: $m</option>";
                                            }
                                        }
                                    }
                                    ?>
                                </datalist>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Fecha <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="fecha" id="fechaWalkin" style="border-radius: 8px;" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Hora <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="hora" id="horaWalkin" style="border-radius: 8px;" required>
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label fw-bold">Motivo</label>
                                <select class="form-select" name="id_motivo" id="motivoWalkin" style="border-radius: 8px;" required>
                                    <option value="1">Consulta General</option>
                                    <option value="2">Revisión Result.</option>
                                    <option value="3">Urgencia Ligera</option>
                                </select>
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal" style="border-radius: 8px;">Cancelar</button>
                                <button type="submit" class="btn text-white" style="background-color: var(--utm-secondary); border-radius: 8px; font-weight: bold;">Registrar Cita</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const today = new Date();
            const localeDate = new Date(today.getTime() - today.getTimezoneOffset() * 60000).toISOString().split('T')[0];
            document.getElementById('fechaWalkin').value = localeDate;
            document.getElementById('fechaWalkin').setAttribute('min', localeDate);
            
            document.getElementById('tipoPaciente').addEventListener('change', function() {
                if (this.value === 'invitado') {
                    document.getElementById('divNombreInvitado').classList.remove('d-none');
                    document.getElementById('nombre_invitado').setAttribute('required', 'required');
                    
                    document.getElementById('divPacienteExistente').classList.add('d-none');
                    document.getElementById('matricula_paciente').removeAttribute('required');
                } else {
                    document.getElementById('divPacienteExistente').classList.remove('d-none');
                    document.getElementById('matricula_paciente').setAttribute('required', 'required');
                    
                    document.getElementById('divNombreInvitado').classList.add('d-none');
                    document.getElementById('nombre_invitado').removeAttribute('required');
                }
            });

            document.getElementById('formWalkIn').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('tipo_paciente', document.getElementById('tipoPaciente').value);
                
                fetch('../backend/api/registrar_walkin.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Éxito', 'Cita presencial registrada.', 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Ocurrió un error en la conexión.', 'error');
                });
            });
        });
    </script>
<!-- Notificaciones Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let bellNodes = document.querySelectorAll('a[data-bs-toggle="dropdown"] i.bi-bell-fill');
    bellNodes.forEach(icon => {
        let toggle = icon.closest('a');
        if (toggle) {
            toggle.addEventListener('hidden.bs.dropdown', function() {
                let badge = toggle.querySelector('.bg-danger');
                if (badge) badge.remove();
                fetch('../backend/api/accion_leer_notificaciones.php', { method: 'POST' }).catch(e => console.error(e));
            });
        }
    });
});
</script>
</body>
</html>

