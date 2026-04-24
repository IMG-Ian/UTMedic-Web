<?php
header('Content-Type: text/html; charset=utf-8');
// Importar el escudo protector de rutas validando que sea Médico (Profesional en BD)
require_once __DIR__ . '/../../backend/auth_medico.php';
require_once __DIR__ . '/../../backend/config/paths.php';
require_once __DIR__ . '/../../backend/api/obtener_dashboard_medico.php';
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

                        <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'dashboard-psicologo.php' ? 'active' : '' ?>">
                            <a href="dashboard-psicologo.php" class="sidebar-link">
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
                    <h3>Panel de Psicólogo</h3>
                    <div class="d-flex align-items-center gap-3">




                        <?php require_once '../backend/componentes/notificaciones_logic.php'; ?>
                        <div class="dropdown">
                            <a href="#" class="position-relative text-decoration-none" data-bs-toggle="dropdown" id="notifDropdownToggle" aria-expanded="false">
                                <i class="bi bi-bell-fill fs-4 text-muted"></i>
                                <?php if (isset($unreadCount) && $unreadCount > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;"><?= $unreadCount ?></span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="dropdownMenuButton" style="width: 300px; padding: 10px; max-height: 400px; overflow-y: auto; overflow-x: hidden;">
                                <li>
                                    <h6 class="dropdown-header font-bold text-dark d-flex justify-content-between align-items-center pb-2">
                                        Notificaciones
                                    </h6>
                                </li>
                                <?php if (empty($notificacionesList)): ?>
                                    <li>
                                        <div class="dropdown-item text-muted text-center py-4" style="font-size: 0.9rem; white-space: normal;">No tienes notificaciones recientes.</div>
                                    </li>
                                <?php else: ?>
                                    <?php foreach ($notificacionesList as $notif):
                                        $icon = 'bi-info-circle';
                                        $bgClass = 'bg-secondary';
                                        if ($notif['tipo'] === 'nueva_cita') {
                                            $icon = 'bi-calendar-plus';
                                            $bgClass = 'bg-primary';
                                        }
                                        if ($notif['tipo'] === 'cancelacion') {
                                            $icon = 'bi-calendar-x';
                                            $bgClass = 'bg-danger';
                                        }
                                        if ($notif['tipo'] === 'completada') {
                                            $icon = 'bi-check-circle';
                                            $bgClass = 'bg-success';
                                        }

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
                                <h6 class="mb-0 fs-6 user-name-display text-dark opacity-100"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Psicólogo') ?></h6>
                                <p class="mb-0 text-muted" style="font-size: 0.75rem;">Psicólogo</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="page-content">
                <section class="row">
                    <!-- Left Column: Bienvenida y Citas del Día -->
                    <div class="col-12 col-lg-8">

                        <!-- Tarjeta de Bienvenida -->
                        <div class="card mb-4 shadow-sm border-0" style="background: linear-gradient(135deg, #005461 0%, #018790 100%); border-radius: 1rem;">
                            <div class="card-body py-4 px-5">
                                <h2 class="fw-bold mb-3" style="color: white !important;">¡Buen día, <span style="color: var(--utm-accent) !important;"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Psicólogo') ?></span>!</h2>
                                <p class="mb-4 fs-5" style="color: rgba(255,255,255,0.85);">Ten un excelente día usando<br>utmedic para tus citas de psicólogo.</p>
                                <a href="medico-agenda.php" class="btn rounded-pill px-4 py-2 shadow-sm fw-bold text-dark" style="background-color: var(--utm-accent); border: 1px solid var(--utm-accent); transition: all 0.3s ease;">Atender las Citas</a>
                            </div>
                        </div>

                        <!-- Tarjeta Citas del Día -->
                        <div class="card shadow-sm border-0" style="background: var(--bs-card-bg); border-radius: 1rem; box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05);">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-center mb-4">
                                    <span class="badge rounded-pill bg-light text-dark px-4 py-2 fs-6 shadow-sm border" style="font-weight: 600;">Citas a atender</span>
                                </div>

                                <div class="row px-2" id="citas-dia-container">
                                    <div class="col-12 text-center text-muted py-4">
                                        <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                        <span class="ms-2">Cargando citas...</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta Citas Atendidas (Gráfico movido) -->
                        <div class="card shadow-sm border-0" style="background: var(--bs-card-bg); border-radius: 1rem; box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05);">
                            <div class="card-body p-4 text-center">
                                <h4 class="fw-bold text-dark mb-3">Citas Atendidas</h4>
                                <div class="rounded p-2 shadow-sm border" style="border-radius: 12px !important; background: var(--bs-body-bg);">
                                    <div id="chart-citas-pendientes"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Emergencia y Estadísticas -->
                    <div class="col-12 col-lg-4">

                        <!-- Mini Calendar -->
                        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
                            <div class="card-header bg-transparent border-0 pt-4 pb-2 text-center">
                                <h5 class="font-bold mb-0">Calendario</h5>
                            </div>
                            <div class="card-body p-3">
                                <!-- Calendar Container para JS -->
                                <div class="calendar-wrapper border rounded-3 p-3" style="background: var(--bs-body-bg);">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="fw-bold fs-6 text-body" id="calendar-title">Cargando...</span>
                                        <div class="gap-1 d-flex">
                                            <button class="btn btn-sm btn-light py-0 px-2" id="prev-month-btn">
                                                <i class="bi bi-chevron-left small"></i>
                                            </button>
                                            <button class="btn btn-sm btn-light py-0 px-2" id="next-month-btn">
                                                <i class="bi bi-chevron-right small"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="calendar-grid text-center" style="font-size: 0.85rem;">
                                        <div class="row gx-1 fw-bold text-muted mb-2">
                                            <div class="col">Lun</div>
                                            <div class="col">Mar</div>
                                            <div class="col">Mié</div>
                                            <div class="col">Jue</div>
                                            <div class="col">Vie</div>
                                            <div class="col">Sáb</div>
                                            <div class="col">Dom</div>
                                        </div>
                                        <!-- Los días se inyectarán aquí -->
                                        <div id="calendar-days"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
            </div>

            <!-- Div movido a izquierda -->
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



    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/static/js/pages/dashboard.js"></script>

    <!-- Custom ApexCharts Initialization for Doctor Dashboard -->
    <script>
        // --- LÓGICA DEL CALENDARIO DINÁMICO ---
        let patientAppointmentsDates = <?= json_encode($dashboardData["calendarioFechas"] ?? []) ?>;
        let currentDate = new Date();

        document.addEventListener('DOMContentLoaded', function() {
            // 3. Renderizar ApexCharts Gráfico de Barras Citas Pendientes
            var pendienteOptions = {
                series: [{
                    name: "Citas",
                    data: <?= json_encode($dashboardData["chart"]["series"] ?? []) ?>
                }],
                chart: {
                    type: "bar",
                    height: 260,
                    toolbar: {
                        show: false
                    },
                    dropShadow: {
                        enabled: true,
                        top: 2,
                        left: 0,
                        blur: 4,
                        opacity: 0.1
                    }
                },
                colors: ["var(--utm-primary)"],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "40%",
                        borderRadius: 5
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ["transparent"]
                },
                xaxis: {
                    categories: <?= json_encode($dashboardData["chart"]["labels"] ?? []) ?>,
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    title: {
                        text: "N° Citas",
                        style: {
                            color: "#6c757d",
                            fontWeight: 600
                        }
                    },
                    labels: {
                        style: {
                            colors: "#6c757d"
                        }
                    },
                    tickAmount: <?= max(($dashboardData["chart"]["series"] ?? [0])) > 5 ? 5 : max(($dashboardData["chart"]["series"] ?? [0])) ?>
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    theme: "light",
                    y: {
                        formatter: function(val) {
                            return val + " citas"
                        }
                    }
                }
            };
            var chart = new ApexCharts(document.querySelector("#chart-citas-pendientes"), pendienteOptions);
            chart.render();

            renderCalendar();

            // Rellenar dinámicamente Citas del Día y Pendientes
            const dashboardDataObj = <?= json_encode($dashboardData ?? []) ?>;
            const citasContainer = document.getElementById('citas-dia-container');
            const countContainer = document.getElementById('citas-atendidas-count');

            if (countContainer) {
                countContainer.innerText = dashboardDataObj.totalPendientes ?? 0;
            }

            if (citasContainer) {
                if (!dashboardDataObj.citasDia || dashboardDataObj.citasDia.length === 0) {
                    citasContainer.innerHTML = '<div class="col-12 text-center text-muted py-4"><i class="bi bi-calendar-x opacity-50 mb-3" style="font-size: 2rem;"></i><p class="mb-0">No hay citas para hoy.</p></div>';
                } else {
                    let html = '';
                    dashboardDataObj.citasDia.forEach(cita => {
                        html += `
                        <div class="col-12 col-md-6 col-lg-5 mb-4">
                            <div class="card h-100 border-0 shadow-sm" style="background: var(--utm-accent); color: white; border-radius: 0.8rem;">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="text-white font-bold mb-0">Cita Médica</h5>
                                    </div>
                                    <div class="d-flex align-items-center mb-2" style="color: rgba(255, 255, 255, 0.9);">
                                        <i class="bi bi-clock me-2"></i>
                                        <span>${cita.horario}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-4" style="color: rgba(255, 255, 255, 0.9);">
                                        <i class="bi bi-person me-2"></i>
                                        <span>${cita.paciente}</span>
                                    </div>
                                    <a href="medico-agenda.php" class="btn btn-sm w-100 fw-bold text-white px-4" style="border-radius: 50px; background-color: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.5); transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.3)'" onmouseout="this.style.backgroundColor='rgba(255,255,255,0.2)'">Atender Cita</a>
                                </div>
                            </div>
                        </div>`;
                    });
                    citasContainer.innerHTML = html;
                }
            }
        });

        function renderCalendar() {
            const monthYearString = currentDate.toLocaleString('es-ES', {
                month: 'long',
                year: 'numeric'
            });
            document.getElementById('calendar-title').innerText = monthYearString.charAt(0).toUpperCase() + monthYearString.slice(1);

            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);

            let startingDay = firstDay.getDay() - 1;
            if (startingDay === -1) startingDay = 6;

            const totalDays = lastDay.getDate();
            const prevMonthLastDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0).getDate();

            let html = '';
            let dayCount = 1;
            let nextMonthDayCount = 1;

            const today = new Date();
            const isCurrentMonth = today.getMonth() === currentDate.getMonth() && today.getFullYear() === currentDate.getFullYear();

            for (let row = 0; row < 6; row++) {
                html += '<div class="row gx-1 mb-1">';
                for (let col = 0; col < 7; col++) {
                    if (row === 0 && col < startingDay) {
                        const prevDay = prevMonthLastDay - startingDay + col + 1;
                        html += `<div class="col text-muted opacity-50">${prevDay}</div>`;
                    } else if (dayCount > totalDays) {
                        html += `<div class="col text-muted opacity-50">${nextMonthDayCount++}</div>`;
                    } else {
                        const loopDateStr = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(dayCount).padStart(2, '0')}`;
                        const isAppointmentDay = patientAppointmentsDates.includes(loopDateStr);

                        if (isCurrentMonth && dayCount === today.getDate()) {
                            html += `<div class="col text-white fw-bold rounded-circle" style="background-color: var(--utm-secondary);" title="Hoy">${dayCount}</div>`;
                        } else if (isAppointmentDay) {
                            html += `<div class="col text-dark fw-bold rounded-circle shadow-sm" style="background-color: var(--utm-accent); cursor: pointer;" title="Tienes evento médico este día">${dayCount}</div>`;
                        } else {
                            html += `<div class="col cursor-pointer hover-bg-light rounded-circle" style="cursor: pointer;">${dayCount}</div>`;
                        }
                        dayCount++;
                    }
                }
                html += '</div>';
                if (dayCount > totalDays && row > 3) break;
            }

            document.getElementById('calendar-days').innerHTML = html;
        }

        document.getElementById('prev-month-btn').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById('next-month-btn').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        renderCalendar();
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
                        fetch('../backend/api/accion_leer_notificaciones.php', {
                            method: 'POST'
                        }).catch(e => console.error(e));
                    });
                }
            });
        });
    </script>
</body>

</html>