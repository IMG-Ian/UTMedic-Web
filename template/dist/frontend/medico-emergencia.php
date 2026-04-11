<?php
header('Content-Type: text/html; charset=utf-8');
// Importar el escudo protector de rutas validando que sea Médico (Profesional en BD)
require_once __DIR__ . '/../backend/auth_medico.php';

$active_page = 'emergencia';
?>
<!DOCTYPE html>
<html lang="en">

<head>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .light-bar {
            animation: flash 1s infinite alternate;
        }
        .red-light {
            box-shadow: 0 0 15px 5px rgba(220, 53, 69, 0.5);
        }
        .blue-light {
            box-shadow: 0 0 15px 5px rgba(13, 202, 240, 0.5);
            animation-delay: 0.5s;
        }
        @keyframes flash {
            0% { opacity: 0.5; }
            100% { opacity: 1; filter: brightness(1.5); }
        }
    </style>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative px-4 py-3">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="logo align-items-center d-flex mb-0">
                            <a href="index.php" class="text-decoration-none">
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
                            <!-- Iconos luna sol movidos o removidos -->
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menú Principal</li>

                        <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'dashboard-medico.php' ? 'active' : '' ?>">
                            <a href="dashboard-<?= isset($_SESSION['especialidad']) ? (strpos(strtolower($_SESSION['especialidad']), 'nutri') !== false ? 'nutricionista' : (strpos(strtolower($_SESSION['especialidad']), 'psicolo') !== false ? 'psicologo' : 'medico')) : 'medico' ?>.php" class="sidebar-link">
                                <i class="bi bi-house-door-fill"></i>
                                <span>Inicio</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'medico-agenda.php' ? 'active' : '' ?>">
                            <a href="medico-agenda.php" class="sidebar-link">
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

                        <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'user-perfil.php' ? 'active' : '' ?>">
                            <a href="user-perfil.php" class="sidebar-link">
                                <i class="bi bi-person-circle"></i>
                                <span>Perfil</span>
                            </a>
                        </li>
                        
                        <!-- Cierre de sesión -->
                        <li class="sidebar-item mt-5 pt-3 border-top">
                            <a href="../backend/logout.php" class="sidebar-link text-danger">
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
                    <h3>Registro de Emergencia</h3>
                    <div class="d-flex align-items-center gap-3">
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
                        <a href="user-perfil.php" class="text-decoration-none d-flex align-items-center top-nav-profile-container" style="background: rgba(0,0,0,0.03); padding: 5px 15px; border-radius: 50px; border: 1px solid rgba(0,0,0,0.05); cursor: pointer;">
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
                <div class="row justify-content-center">
                    <div class="col-12 col-md-11 col-lg-9">
                        
                        <div class="text-center mb-5">
                            <h3 class="font-bold text-dark">Registro Emergencia</h3>
                            <p class="text-muted fs-5">"Por favor, complete la siguiente información para registrar la emergencia"</p>
                        </div>

                        <!-- AMBULANCE SHAPE CONTAINER -->
                        <div class="ambulance-container position-relative mx-auto mt-4 mb-5" style="max-width: 850px;">
                            <!-- Lightbars on top -->
                            <div class="position-absolute d-flex justify-content-between w-100 px-5" style="top: -20px; left: 0; z-index: 2;">
                                <div class="light-bar red-light bg-danger rounded-top" style="width: 60px; height: 25px;"></div>
                                <div class="siren bg-secondary rounded-top px-3 text-center text-white lh-base fw-bold" style="width: 90px; height: 25px; font-size: 0.7rem; padding-top:4px; letter-spacing: 1px;">S.O.S</div>
                                <div class="light-bar blue-light bg-info rounded-top" style="width: 60px; height: 25px;"></div>
                            </div>

                            <div class="card shadow-lg border-2 border-info" style="
                                border-radius: 15px; 
                                border-top-right-radius: 90px; 
                                border-bottom: 12px solid #343a40;
                                background-color: var(--bs-card-bg);">
                                

                                <div class="card-body p-4 p-md-5 position-relative" style="z-index: 1;">
                                    <form id="emergencyForm">
                                        <div class="row g-4">
                                            <!-- Izquierda -->
                                            <div class="col-md-6 border-end pe-4">
                                                <h6 class="fw-bold mb-4 text-primary">Datos de la Emergencia:</h6>
                                                
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold text-dark mb-1">Nombre Paciente <span class="text-danger">*</span></label>
                                                    <input type="text" name="nombre_paciente" id="emergencia_nombre" class="form-control form-control-lg border-2" placeholder="Ingresa el nombre completo" style="border-radius: 8px;" required>
                                                </div>
                                                
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold text-dark mb-1">Tipo de Emergencia <span class="text-danger">*</span></label>
                                                    <select name="tipo_emergencia" id="emergencia_tipo" class="form-select form-select-lg border-2" style="border-radius: 8px;" required>
                                                        <option value="" selected disabled>Selecciona un tipo principal</option>
                                                        <option value="Traumatismo">Traumatismo / Accidente</option>
                                                        <option value="Cardiaca">Emergencia Cardíaca (Infarto)</option>
                                                        <option value="Respiratoria">Emergencia Respiratoria</option>
                                                        <option value="Neurologica">Emergencia Neurológica</option>
                                                        <option value="Otro">Otro</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="row g-3">
                                                    <div class="col-6">
                                                        <label class="form-label fw-bold text-dark mb-1">Fecha de la Emergencia <span class="text-danger">*</span></label>
                                                        <input type="date" name="fecha_emergencia" class="form-control border-2 text-center" style="border-radius: 8px;" required id="defaultDate">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label fw-bold text-dark mb-1">Hora de la Emergencia <span class="text-danger">*</span></label>
                                                        <input type="time" name="hora_emergencia" class="form-control border-2 text-center" style="border-radius: 8px;" required id="defaultTime">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Derecha -->
                                            <div class="col-md-6 ps-md-4">
                                                <h6 class="fw-bold mb-4 text-primary">Observación:</h6>
                                                
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold text-dark mb-1">Ingrese una observación/dato de la emergencia:</label>
                                                    <textarea name="observaciones" id="emergencia_observaciones" class="form-control border-2" rows="6" placeholder="Escríbelo aquí la evaluación rápida o condición de llegada..." style="border-radius: 8px; resize: none;"></textarea>
                                                </div>
                                                
                                                <div class="mb-3 pt-2">
                                                    <label class="form-label fw-bold text-dark d-block mb-3">Requirió Ambulancia <span class="text-danger">*</span></label>
                                                    <div class="d-flex gap-4">
                                                        <div class="form-check form-check-inline form-check-lg" style="transform: scale(1.2);">
                                                            <input class="form-check-input border-2 border-primary cursor-pointer" type="radio" name="ambulanciaRadio" id="ambSi" value="SI">
                                                            <label class="form-check-label fw-bold text-dark ms-1 cursor-pointer" for="ambSi">SI</label>
                                                        </div>
                                                        <div class="form-check form-check-inline form-check-lg" style="transform: scale(1.2);">
                                                            <input class="form-check-input border-2 border-secondary cursor-pointer" type="radio" name="ambulanciaRadio" id="ambNo" value="NO" checked>
                                                            <label class="form-check-label fw-bold text-dark ms-1 cursor-pointer" for="ambNo">NO</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-5 pt-3 border-top text-center">
                                            <button type="submit" class="btn btn-primary text-white px-5 py-3 w-100 fw-bold fs-5 shadow-lg" style="border-radius: 12px; background-color: var(--utm-accent); border-color: var(--utm-accent); letter-spacing: 1px;">
                                                <i class="bi bi-file-earmark-medical me-2"></i> Registrar Emergencia
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Wheels -->
                            <div class="position-absolute rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; bottom: -40px; left: 100px; border: 15px solid #212529; background-color: #e9ecef; z-index: 3;">
                                <div class="bg-dark rounded-circle" style="width: 20px; height:20px;"></div>
                            </div>
                            <div class="position-absolute rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; bottom: -40px; right: 120px; border: 15px solid #212529; background-color: #e9ecef; z-index: 3;">
                                <div class="bg-dark rounded-circle" style="width: 20px; height:20px;"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted pb-4 mt-5">
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Autocompletar fecha y hora actual
            const now = new Date();
            // Evitar offset en la timezone
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            const dateStr = now.toISOString().split('T')[0];
            const timeStr = now.toISOString().split('T')[1].substring(0,5);
            
            document.getElementById('defaultDate').value = dateStr;
            document.getElementById('defaultTime').value = timeStr;

            document.getElementById('emergencyForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                fetch('../backend/api/registrar_emergencia.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: '¡Emergencia Registrada!',
                            text: 'Los datos de la emergencia se guardaron exitosamente en la bitácora.',
                            icon: 'success',
                            confirmButtonColor: '#018790'
                        }).then(() => {
                            this.reset();
                            document.getElementById('defaultDate').value = dateStr;
                            document.getElementById('defaultTime').value = timeStr;
                            document.getElementById('ambNo').checked = true;
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Error al guardar la emergencia.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    Swal.fire('Error', 'Ocurrió un error en el servidor.', 'error');
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
