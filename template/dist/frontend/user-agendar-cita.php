<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth-login.php");
    exit();
}
$nombreEstudiante = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuario';
$rolUsuario = isset($_SESSION['role']) ? ucfirst(strtolower($_SESSION['role'])) : 'Usuario Regular';
$avatarUsuario = isset($_SESSION['user_avatar']) ? $_SESSION['user_avatar'] : 'assets/compiled/jpg/1.jpg';
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
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="assets/css/utmedic-global.css">
    <link rel="stylesheet" href="assets/css/utmedic-dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                <h3 class="mb-0 fw-bold" style="color: var(--utm-green); letter-spacing: 1px;">UTMedic</h3>
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
                    <h3>Agendar Cita</h3>
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
                                        <div class="bg-success text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 35px; height: 35px;">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-sm font-bold text-dark">Cita Aceptada</h6>
                                            <p class="mb-0 text-xs text-muted" style="font-size: 0.8rem;">Tu cita del 15 de Nov. ha sido confirmada.</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center py-2 rounded mt-1" href="#" style="white-space: normal;">
                                        <div class="bg-warning text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 35px; height: 35px;">
                                            <i class="bi bi-calendar-x"></i>
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
                                <img src="<?= htmlspecialchars($avatarUsuario) ?>" id="top-nav-avatar" alt="Avatar" style="width: 32px; height: 32px; object-fit: cover; color: transparent; text-indent: -9999px;">
                            </div>
                            <div class="ms-2">
                                <h6 class="mb-0 fs-6 user-name-display text-dark opacity-100"><?= htmlspecialchars($nombreEstudiante) ?></h6>
                                <p class="mb-0 text-muted" style="font-size: 0.75rem;"><?= htmlspecialchars($rolUsuario) ?></p>
                            </div>
                        </a>
                        <a href="../backend/logout.php" class="btn btn-outline-danger btn-sm d-flex align-items-center" style="border-radius: 50px; padding: 5px 15px; font-weight: 600;" title="Cerrar Sesión">
                            <i class="bi bi-box-arrow-right me-1"></i> Salir
                        </a>
                    </div>
                </div>
            </div>

            <div class="page-content">
                <section class="row">
                    <!-- Left Column: Form Details -->
                    <div class="col-12 col-lg-8">

                        <!-- Step 1 & 2: Specialty and Doctor -->
                        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
                            <div class="card-header bg-transparent border-0 pt-4 pb-2">
                                <h5 class="font-bold mb-0">1. Detalles de la Consulta</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="specialtySelect" class="form-label fw-bold">Especialidad</label>
                                        <select class="form-select" id="specialtySelect"
                                            style="border-radius: 50px; padding: 0.6rem 1.2rem;">
                                            <option selected>Selecciona una opción...</option>
                                            <option value="1">Medicina General</option>
                                            <option value="2">Nutrición</option>
                                            <option value="3">Psicología</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="doctorSelect" class="form-label fw-bold">Profesional</label>
                                        <select class="form-select" id="doctorSelect"
                                            style="border-radius: 50px; padding: 0.6rem 1.2rem;">
                                            <option selected>Cualquier Profesional Disponible</option>
                                            <option value="1">Dr. Juan Pérez</option>
                                            <option value="2">Dra. María González</option>
                                            <option value="3">Lic. Andrea Martínez</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="reasonInput" class="form-label fw-bold">Motivo de la Consulta
                                            (Opcional)</label>
                                        <textarea class="form-control" id="reasonInput" rows="3"
                                            placeholder="Describe brevemente el motivo de tu visita..."
                                            style="border-radius: 1rem; padding: 1rem;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Date and Time slots -->
                        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
                            <div class="card-header bg-transparent border-0 pt-4 pb-2">
                                <h5 class="font-bold mb-0">2. Fecha y Hora</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <!-- Date Picker -->
                                    <div class="col-md-6">
                                        <label for="dateSelect" class="form-label fw-bold">Selecciona el Día</label>
                                        <input type="date" class="form-control" id="dateSelect"
                                            style="border-radius: 50px; padding: 0.6rem 1.2rem;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Horarios Disponibles</label>
                                        <style>
                                            .btn-outline-utm-green {
                                                color: #1a9b8e !important;
                                                border-color: #1a9b8e !important;
                                                background-color: transparent !important;
                                                transition: all 0.2s ease-in-out;
                                            }
                                            .btn-outline-utm-green:hover, 
                                            .btn-outline-utm-green.active {
                                                background-color: rgba(26, 155, 142, 0.15) !important;
                                                color: #1a9b8e !important;
                                                border-color: #1a9b8e !important;
                                                box-shadow: 0 0 0 0.25rem rgba(26, 155, 142, 0.25) !important;
                                            }
                                        </style>
                                        <div class="d-flex flex-wrap gap-2" id="timeSlotsContainer">
                                            <button type="button" class="btn btn-outline-utm-green time-slot-btn" data-time="09:00:00"
                                                style="border-radius: 50px;">09:00 AM</button>
                                            <button type="button" class="btn btn-outline-utm-green time-slot-btn" data-time="09:30:00"
                                                style="border-radius: 50px;">09:30 AM</button>
                                            <button type="button" class="btn btn-outline-utm-green time-slot-btn" data-time="10:00:00"
                                                style="border-radius: 50px;">10:00 AM</button>
                                            <button type="button" class="btn btn-outline-secondary disabled"
                                                style="border-radius: 50px;">10:30 AM</button>
                                            <button type="button" class="btn btn-outline-utm-green time-slot-btn" data-time="11:00:00"
                                                style="border-radius: 50px;">11:00 AM</button>
                                            <button type="button" class="btn btn-outline-utm-green time-slot-btn" data-time="11:30:00"
                                                style="border-radius: 50px;">11:30 AM</button>
                                            <button type="button" class="btn btn-outline-secondary disabled"
                                                style="border-radius: 50px;">12:00 PM</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Summary -->
                    <div class="col-12 col-lg-4">

                        <div class="card shadow-sm border-0 mb-4"
                            style="border-radius: 1rem; position: sticky; top: 2rem;">
                            <div class="card-header bg-transparent border-0 pt-4 pb-0 text-center">
                                <h5 class="font-bold">Resumen de Cita</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="bg-light p-4 rounded-3 mb-4">
                                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                        <span class="text-muted"><i class="bi bi-briefcase me-2"></i>Especialidad</span>
                                        <span class="fw-bold text-end" id="summary-specialty">Selecciona esp...</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                        <span class="text-muted"><i class="bi bi-person me-2"></i>Profesional</span>
                                        <span class="fw-bold text-end" id="summary-doctor">Cualquier Disp.</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                        <span class="text-muted"><i class="bi bi-calendar me-2"></i>Fecha</span>
                                        <span class="fw-bold text-end" id="summary-date">--/--/----</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted"><i class="bi bi-clock me-2"></i>Hora</span>
                                        <span class="fw-bold text-end text-primary" id="summary-time">--:--</span>
                                    </div>
                                </div>
                                <button id="btnConfirmarCita" class="btn w-100 fw-bold py-3 text-white"
                                    style="background-color: #1a9b8e; border-radius: 50px; font-size: 1.1rem;">
                                    Confirmar Cita
                                </button>
                                <div class="text-center mt-3">
                                    <a href="index.php" class="text-muted text-decoration-none small">Cancelar</a>
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
        document.addEventListener('DOMContentLoaded', () => {
            const specialtySelect = document.getElementById('specialtySelect');
            const doctorSelect = document.getElementById('doctorSelect');
            const dateSelect = document.getElementById('dateSelect');
            const timeButtons = document.querySelectorAll('.time-slot-btn:not(.disabled)');
            
            const summarySpecialty = document.getElementById('summary-specialty');
            const summaryDoctor = document.getElementById('summary-doctor');
            const summaryDate = document.getElementById('summary-date');
            const summaryTime = document.getElementById('summary-time');
            const btnConfirmarCita = document.getElementById('btnConfirmarCita');

            let selectedTime = null;
            let professionalsData = [];

            // Restringir Fecha Minima a HOY en el calendario
            const today = new Date();
            // Restamos Timezone offset para evitar fallos por GMT 
            const localeDate = new Date(today.getTime() - today.getTimezoneOffset() * 60000).toISOString().split('T')[0];
            dateSelect.setAttribute('min', localeDate);

            // Cargar Doctores Dinámicamente desde el backend
            fetch('../backend/api/obtener_profesionales.php')
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        professionalsData = data.data;
                        updateDoctorSelect();
                    }
                })
                .catch(err => console.error('Error fetching professionals:', err));

            // Actualizar Opciones de los Doctores (Select)
            function updateDoctorSelect() {
                doctorSelect.innerHTML = '<option value="">Selecciona un Profesional...</option>';
                professionalsData.forEach(doc => {
                    doctorSelect.innerHTML += `<option value="${doc.id}">${doc.nombre} (${doc.profesion})</option>`;
                });
            }

            // --- Listeners de Actualización al Resumen de la Derecha ---
            specialtySelect.addEventListener('change', () => {
                summarySpecialty.innerText = specialtySelect.value !== "Selecciona una opción..." 
                    ? specialtySelect.options[specialtySelect.selectedIndex].text 
                    : 'Seleccione esp...';
            });

            doctorSelect.addEventListener('change', () => {
                summaryDoctor.innerText = doctorSelect.value === '' 
                    ? '---' 
                    : doctorSelect.options[doctorSelect.selectedIndex].text;
            });

            dateSelect.addEventListener('change', () => {
                if (dateSelect.value) {
                    const [y, m, d] = dateSelect.value.split('-');
                    summaryDate.innerText = `${d}/${m}/${y}`;
                } else {
                    summaryDate.innerText = '--/--/----';
                }
            });

            // --- Listener al Clickeo de los Horarios Verdes ---
            timeButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Remover estado 'activo' de todos los botones para que quede apagado
                    timeButtons.forEach(b => {
                        b.classList.remove('active');
                        // Asegurarnos de que todos vuelven al "outline" base
                    });
                    
                    // Poner estado activo SOLO a este botón.
                    // El CSS que agregamos arriba (.btn-outline-utm-green.active) se encargará
                    // orgánicamente de ponerle el fondo verde clarito.
                    btn.classList.add('active');

                    // Actualizar variable global y el resumen gráfico
                    selectedTime = btn.getAttribute('data-time');
                    summaryTime.innerText = btn.innerText;
                });
            });

            // --- Disparador para Guardar la Cita Final ---
            btnConfirmarCita.addEventListener('click', () => {
                const doctorId = doctorSelect.value;
                const fecha = dateSelect.value;
                const observaciones = document.getElementById('reasonInput').value;

                // Validar que no le falten datos al paciente
                if (!fecha || !selectedTime) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Horario Requerido',
                        text: 'Por favor selecciona una fecha y un horario disponible.'
                    });
                    return;
                }
                if (!doctorId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Profesional Requerido',
                        text: 'Por favor selecciona obligatoriamente a un Profesional.'
                    });
                    return;
                }

                // Deshabilitar botón temporalmente para que no haga "doble click" o inyecte dos citas
                btnConfirmarCita.disabled = true;
                btnConfirmarCita.innerText = 'Guardando...';

                // Enviar la estructura en JSON crudo a nuestro endpoint PHP
                fetch('../backend/api/crear_cita.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        idPersonal: doctorId,
                        fecha: fecha,
                        hora: selectedTime,
                        observaciones: observaciones
                    })
                })
                .then(res => res.json())
                .then(data => {
                    btnConfirmarCita.disabled = false;
                    btnConfirmarCita.innerText = 'Confirmar Cita';
                    
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Cita Agendada!',
                            text: 'Tu cita se ha guardado exitosamente en el sistema.',
                            confirmButtonColor: '#1a9b8e'
                        }).then(() => {
                            window.location.href = 'index.php'; // Redirigirlo a inicio
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Algo salió mal',
                            text: data.message
                        });
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'Falló la conexión al servidor. Revisa tu internet.'
                    });
                    btnConfirmarCita.disabled = false;
                    btnConfirmarCita.innerText = 'Confirmar Cita';
                });
            });
        });
    </script>
</body>

</html>