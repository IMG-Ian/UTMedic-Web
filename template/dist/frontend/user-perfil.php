<?php
header('Content-Type: text/html; charset=utf-8');
// Iniciar sesión para recuperar datos del usuario
session_start();

// Validar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Si no está autenticado, redirigir al login
    header("Location: auth-login.php");
    exit(); // Terminar ejecución para evitar cargar la página
}

// Variables opcionales por si se quiere pintar algún dato que aún no esté en sesión
// y evitar Note/Warning si $_SESSION está vacío.
$nombreEstudiante = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuario';
$rolUsuario = isset($_SESSION['role']) ? ucfirst(strtolower($_SESSION['role'])) : 'Usuario Regular';
$avatarUsuario = isset($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : 'assets/compiled/jpg/1.jpg';
?>
<!DOCTYPE html>
<html lang="es">

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

                        <?php if (isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'profesional'): ?>
                            <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'dashboard-medico.php' ? 'active' : '' ?>">
                                <a href="dashboard-medico.php" class="sidebar-link">
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
                            <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'medico-historial.php' ? 'active' : '' ?>">
                                <a href="medico-historial.php" class="sidebar-link">
                                    <i class="bi bi-clock-history"></i>
                                    <span>Historial Citas</span>
                                </a>
                            </li>
                            <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'medico-emergencia.php' ? 'active' : '' ?>">
                                <a href="medico-emergencia.php" class="sidebar-link">
                                    <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                                    <span>Emergencia</span>
                                </a>
                            </li>
                            <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'user-perfil.php' ? 'active' : '' ?>">
                                <a href="user-perfil.php" class="sidebar-link">
                                    <i class="bi bi-person-circle"></i>
                                    <span>Perfil</span>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                                <a href="index.php" class="sidebar-link">
                                    <i class="bi bi-house-door-fill"></i>
                                    <span>Inicio</span>
                                </a>
                            </li>
    
                            <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'user-agendar-cita.php' ? 'active' : '' ?>">
                                <a href="user-agendar-cita.php" class="sidebar-link">
                                    <i class="bi bi-calendar-plus-fill"></i>
                                    <span>Nueva Cita</span>
                                </a>
                            </li>
    
                            <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'user-historial.php' ? 'active' : '' ?>">
                                <a href="user-historial.php" class="sidebar-link">
                                    <i class="bi bi-clock-history"></i>
                                    <span>Historial Citas</span>
                                </a>
                            </li>
    
                            <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'user-perfil.php' ? 'active' : '' ?>">
                                <a href="user-perfil.php" class="sidebar-link">
                                    <i class="bi bi-person-fill"></i>
                                    <span>Perfil</span>
                                </a>
                            </li>
                        <?php endif; ?>

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
                <!-- Welcome greeting / Title -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Mi Perfil</h3>
                    <div class="d-flex align-items-center gap-3">
                        <div class="dropdown">
                            <a href="#" class="position-relative text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell-fill fs-4 text-muted"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">2</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="dropdownMenuButton" style="width: 300px; padding: 10px;">
                                <li><h6 class="dropdown-header font-bold text-dark">Notificaciones</h6></li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center py-2 rounded" href="#" style="white-space: normal;">
                                        <div class="bg-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 35px; height: 35px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-sm font-bold text-dark">Cita Aceptada</h6>
                                            <p class="mb-0 text-xs text-muted" style="font-size: 0.8rem;">Tu cita del 15 de Nov. ha sido confirmada.</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center py-2 rounded mt-1" href="#" style="white-space: normal;">
                                        <div class="bg-info text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 35px; height: 35px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line><line x1="10" y1="14" x2="14" y2="18"></line><line x1="14" y1="14" x2="10" y2="18"></line></svg>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-sm font-bold text-dark">Cita Reagendada</h6>
                                            <p class="mb-0 text-xs text-muted" style="font-size: 0.8rem;">El cardiólogo solicitó cambio de horario.</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <a href="user-perfil.php" class="text-decoration-none d-flex align-items-center top-nav-profile-container" style="background: rgba(0,0,0,0.03); padding: 5px 15px; border-radius: 50px; border: 1px solid rgba(0,0,0,0.05); cursor: pointer;">
                            <div class="avatar avatar-sm border border-2 border-primary d-flex align-items-center justify-content-center overflow-hidden" style="background: white; border-radius: 50%; min-width: 32px; min-height: 32px;">
                                <img src="<?= htmlspecialchars($avatarUsuario) ?>" id="top-nav-avatar" alt="Avatar" style="width: 32px; height: 32px; object-fit: cover;">
                            </div>
                            <div class="ms-2">
                                <h6 class="mb-0 fs-6 user-name-display text-dark opacity-100"><?= $_SESSION['user_name'] ?? 'Usuario' ?></h6>
                                <p class="mb-0 text-muted" style="font-size: 0.75rem;"><?= htmlspecialchars($rolUsuario) ?></p>
                            </div>
                        </a>
                        <!-- Logout retirado de aquí -->
                    </div>
                </div>
            </div>

            <div class="page-content">
                <section class="section">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
                                <div class="card-body p-4 p-md-5">

                                    <!-- Avatar Upload Section -->
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="position-relative" style="width: 130px; height: 130px;">
                                            <div class="rounded-circle overflow-hidden shadow-sm d-flex align-items-center justify-content-center" style="width: 100%; height: 100%; border: 4px solid #fff; background-color: var(--bs-body-bg);">
                                                <img src="<?= htmlspecialchars($avatarUsuario) ?>" id="main-profile-avatar" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; color: transparent; text-indent: -9999px;">
                                            </div>
                                            <button 
                                                onclick="document.getElementById('avatarInput').click()" 
                                                class="btn btn-primary position-absolute rounded-circle shadow-sm" 
                                                style="background-color: #018790; border-color: #018790; width: 38px; height: 38px; bottom: 0; right: 8px; padding: 0; align-items: center; justify-content: center; line-height: 0;"
                                                title="Cambiar foto de perfil">
                                                <i class="bi bi-camera-fill" style="font-size: 1.1rem; margin: 0; padding: 0; transform: translateY(-1px);"></i>
                                            </button>
                                            <input type="file" id="avatarInput" accept="image/png, image/jpeg, image/jpg" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="text-center mb-5">
                                        <h3 class="font-bold mb-1 text-primary" style="color: #018790 !important;"><?= htmlspecialchars($nombreEstudiante) ?></h3>
                                        <p class="text-muted">Mi Perfil</p>
                                    </div>

                                    <!-- Form -->
                                    <form>
                                        <h6 class="text-muted mb-4 border-bottom pb-2">Información Personal</h6>
                                        <div class="row g-4 mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Nombre</label>
                                                <input type="text" class="form-control"
                                                    style="border-radius: 50px; padding: 0.6rem 1.2rem;" value="<?= htmlspecialchars($nombreEstudiante) ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Apellidos</label>
                                                <input type="text" class="form-control"
                                                    style="border-radius: 50px; padding: 0.6rem 1.2rem;"
                                                    value="">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Correo Electrónico</label>
                                                <input type="email" class="form-control"
                                                    style="border-radius: 50px; padding: 0.6rem 1.2rem;"
                                                    value="">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Teléfono</label>
                                                <input type="tel" class="form-control"
                                                    style="border-radius: 50px; padding: 0.6rem 1.2rem;"
                                                    value="">
                                            </div>
                                        </div>

                                        <h6 class="text-muted mb-4 mt-5 border-bottom pb-2">Contacto de Emergencia</h6>
                                        <div class="row g-4 mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Nombre del Contacto</label>
                                                <input type="text" class="form-control"
                                                    style="border-radius: 50px; padding: 0.6rem 1.2rem;"
                                                    placeholder="Ej. Ana Pérez">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Teléfono de Emergencia</label>
                                                <input type="tel" class="form-control"
                                                    style="border-radius: 50px; padding: 0.6rem 1.2rem;"
                                                    placeholder="Ej. 999-000-0000">
                                            </div>
                                        </div>

                                        <h6 class="text-muted mb-4 mt-5 border-bottom pb-2">Información Médica Básica
                                        </h6>
                                        <div class="row g-4 mb-4">
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Padecimientos Crónicos</label>
                                                <textarea class="form-control" rows="2"
                                                    style="border-radius: 1rem; padding: 1rem;"
                                                    placeholder="Ej. Asma, Diabetes..."></textarea>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Alergias Conocidas</label>
                                                <textarea class="form-control" rows="2"
                                                    style="border-radius: 1rem; padding: 1rem;"
                                                    placeholder="Ej. Penicilina, Nueces..."></textarea>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-5 gap-3">
                                            <button type="button" class="btn btn-light px-4"
                                                style="border-radius: 50px;">Cancelar</button>
                                            <button type="submit" class="btn btn-primary px-5"
                                                style="border-radius: 50px; background-color: #018790; border-color: #018790;">Guardar
                                                Cambios</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
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

    <script>
        document.getElementById('avatarInput').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                
                // Validar tamaño (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('La imagen pesa demasiado. El límite es 5MB.');
                    this.value = ''; // Reset input
                    return;
                }

                const formData = new FormData();
                formData.append('avatar', file);

                // Podemos cambiar el icono de la camara temporalmente por un spinner si quisieramos
                // Aquí se envía
                fetch('../backend/api/subir_avatar.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const newUrl = data.avatar_url + '?t=' + new Date().getTime(); // cache buster
                        
                        // Actualizamos las dos imagenes en pantalla: la del panel centro y la de Navbar arrriba derecha
                        document.getElementById('main-profile-avatar').src = newUrl;
                        
                        const topNavAvatar = document.getElementById('top-nav-avatar');
                        if (topNavAvatar) topNavAvatar.src = newUrl;
                        
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Falló la conexión al servidor. Intenta de nuevo.');
                });
            }
        });
    </script>
</body>

</html>


