<?php
header('Content-Type: text/html; charset=utf-8');
// Importar el escudo protector de rutas validando que sea Administrador (Profesional en BD)
require_once __DIR__ . '/../../backend/auth_admin.php';
require_once __DIR__ . '/../../backend/config/paths.php';
?>
<!DOCTYPE html>
<?php require_once '../../backend/config/paths.php'; ?>
<html lang="en">

<head>
    <base href="../">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="shortcut icon"
        href="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2033%2034'%20fill-rule='evenodd'%20stroke-linejoin='round'%20stroke-miterlimit='2'%20xmlns:v='https://vecta.io/nano'%3e%3cpath%20d='M3%2027.472c0%204.409%206.18%205.552%2013.5%205.552%207.281%200%2013.5-1.103%2013.5-5.513s-6.179-5.552-13.5-5.552c-7.281%200-13.5%201.103-13.5%205.513z'%20fill='%23435ebe'%20fill-rule='nonzero'/%3e%3ccircle%20cx='16.5'%20cy='8.8'%20r='8.8'%20fill='%2341bbdd'/%3e%3c/svg%3e"
        type="image/x-icon">
    <link rel="shortcut icon"
        href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC"
        type="image/png">


    <link rel="stylesheet" href="assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/table-datatable.css">
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="assets/css/utmedic-global.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/utmedic-dashboard.css?v=<?= time() ?>">
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative px-4 py-3">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="logo align-items-center d-flex mb-0">
                            <a href="admin/dashboard-administrador.php" class="text-decoration-none">
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
                        <li class="sidebar-title">Menú Administrador</li>

                        <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'dashboard-administrador.php' ? 'active' : '' ?>">
                            <a href="admin/dashboard-administrador.php" class="sidebar-link">
                                <i class="bi bi-grid-fill"></i>
                                <span>Inicio</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'gestionPSalud.php' ? 'active' : '' ?>">
                            <a href="admin/gestionPSalud.php" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Gestión de Personal de Salud</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'gestionPacientes.php' ? 'active' : '' ?>">
                            <a href="admin/gestionPacientes.php" class='sidebar-link'>
                                <i class="bi bi-person-lines-fill"></i>
                                <span>Gestión de Pacientes</span>
                            </a>
                        </li>

                        <li class="sidebar-item <?= basename($_SERVER['PHP_SELF']) == 'reportes.php' ? 'active' : '' ?>">
                            <a href="admin/reportes.php" class='sidebar-link'>
                                <i class="bi bi-file-earmark-bar-graph-fill"></i>
                                <span>Reportes</span>
                            </a>
                        </li>

                        <li class="sidebar-item mt-5">
                            <a href="<?= BACKEND_URL ?>/logout.php" class='sidebar-link text-danger'>
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
                <a href="#" class="burger-btn d-block d-xl-none" onclick="event.preventDefault();"> <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <section class="section">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Panel de Administración P.Salud</h3>
                            </div>
                        </div>
                    </div>

                    <section class="section">
                        <!-- Stats Cards -->
                        <div class="row mb-4">
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon icon-card mb-2">
                                                    <i class="bi bi-people-fill"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Total Personal Salud</h6>
                                                <h6 class="font-extrabold mb-0" id="totalPersonal">0</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon icon-card mb-2">
                                                    <i class="bi bi-person-check-fill"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">P.de Salud Activo</h6>
                                                <h6 class="font-extrabold mb-0" id="totalPacientes">0</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon icon-card mb-2">
                                                    <i class="bi bi-person-fill-exclamation"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">P.de Salud Inactivo</h6>
                                                <h6 class="font-extrabold mb-0" id="totalCitas">0</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- BOTÓN NUEVO PERSONAL -->
                        <div class="mb-3">
                            <button class="btn btn-primary" onclick="abrirModal()">
                                <i class="bi bi-plus-circle"></i> Nuevo Personal
                            </button>
                        </div>
                        <!-- MODAL NUEVO PERSONAL -->
                        <div class="modal fade" id="modalPSalud" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Nuevo Personal de Salud</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form id="formPSalud">

                                            <div class="row">
                                                <input type="hidden" id="id_profesional">

                                                <!-- 👤 Datos personales -->
                                                <div class="col-md-4 mb-2">
                                                    <label for="nombre" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre" required>
                                                </div>

                                                <div class="col-md-4 mb-2">
                                                    <label for="apellido_pat" class="form-label">Apellido Paterno</label>
                                                    <input type="text" class="form-control" id="apellido_pat" required>
                                                </div>

                                                <div class="col-md-4 mb-2">
                                                    <label for="apellido_mat" class="form-label">Apellido Materno</label>
                                                    <input type="text" class="form-control" id="apellido_mat">
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="correo" class="form-label">Correo</label>
                                                    <input type="email" class="form-control" id="correo" placeholder="ejemplo@correo.com" required>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="password" class="form-label">Contraseña</label>
                                                    <input type="password" class="form-control" id="password" placeholder="Ingrese contraseña" required>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="cedula" class="form-label">Cédula Profesional</label>
                                                    <input type="text" class="form-control" id="cedula" required>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="especialidad" class="form-label">Especialidad</label>
                                                    <select class="form-control" id="especialidad" required>
                                                        <option value="">Seleccionar especialidad</option>
                                                        <option value="medico">Médico</option>
                                                        <option value="psicologo">Psicólogo</option>
                                                        <option value="nutriologo">Nutriólogo</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="horario_inicio" class="form-label">Horario Inicio</label>
                                                    <input type="time" class="form-control" id="horario_inicio" required>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="horario_fin" class="form-label">Horario Fin</label>
                                                    <input type="time" class="form-control" id="horario_fin" required>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="estado" class="form-label">Estado</label>
                                                    <select class="form-control" id="estado" required>
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
                                                    </select>
                                                </div>

                                            </div>

                                        </form>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button class="btn btn-primary" onclick="guardarPSalud()">Guardar</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <script>
                            let modalPSalud;
                            let dataTable;

                            function abrirModal() {

                                document.getElementById('formPSalud').reset();
                                document.getElementById('id_profesional').value = '';
                                document.querySelector('#modalPSalud .modal-title').textContent = "Nuevo Personal de Salud";

                                modalPSalud.show();
                            }

                            function guardarPSalud() {

                                const id = document.getElementById('id_profesional').value;

                                const data = {
                                    nombre: document.getElementById('nombre').value,
                                    apellido_pat: document.getElementById('apellido_pat').value,
                                    apellido_mat: document.getElementById('apellido_mat').value,
                                    correo: document.getElementById('correo').value,
                                    password: document.getElementById('password').value,
                                    cedula: document.getElementById('cedula').value,
                                    especialidad: document.getElementById('especialidad').value,
                                    horario_inicio: document.getElementById('horario_inicio').value,
                                    horario_fin: document.getElementById('horario_fin').value,
                                    estado: document.getElementById('estado').value
                                };

                                let url = `${API_BASE}/admin/pSalud/insertar.php`;

                                //  SI HAY ID → EDITAR
                                if (id) {
                                    data.id_profesional = id;
                                    url = `${API_BASE}/admin/pSalud/editar.php`;
                                }

                                fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify(data)
                                    })
                                    .then(res => res.json())
                                    .then(result => {

                                        if (result.success || result.status === 'success') {
                                            mostrarToast(id ? 'Personal de Salud Actualizado correctamente' : 'Personal de Salud Registrado correctamente');

                                            modalPSalud.hide();

                                            // limpiar form
                                            document.getElementById('formPSalud').reset();
                                            document.getElementById('id_profesional').value = '';
                                            document.querySelector('#modalPSalud .modal-title').textContent = "Nuevo Personal de Salud";

                                            cargarPersonal();
                                            cargarStats(); // recargar tabla
                                        } else {
                                            mostrarToast(result.message, 'danger');
                                        }

                                    })
                                    .catch(err => {
                                        console.error(err);
                                        mostrarToast('Error al guardar el personal de salud', 'danger');
                                    });
                            }

                            function eliminar(id) {

                                // Confirmación antes de desactivar
                                if (!confirm("¿Seguro que quieres desactivar a este usuario?")) {
                                    return;
                                }

                                fetch(`${API_BASE}/admin/pSalud/eliminar.php`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            id_profesional: id
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(result => {

                                        if (result.status === 'success') {
                                            mostrarToast('Personal de Salud Desactivado correctamente');

                                            // Recargar tabla (rápido y sencillo)
                                            cargarPersonal();
                                            cargarStats(); // recargar tabla
                                        } else {
                                            mostrarToast(result.message, 'danger');
                                        }

                                    })
                                    .catch(err => {
                                        console.error('Error al eliminar:', err);
                                        mostrarToast('Error al desactivar el personal de salud', 'danger');
                                    });
                            }

                            function editar(id) {

                                const p = listaPersonalGlobal.find(x => x.id_profesional == id);

                                if (!p) {
                                    console.error("Profesional no encontrado");
                                    mostrarToast('Error: Profesional no encontrado', 'danger');
                                    return;
                                }

                                // llenar inputs
                                document.getElementById('id_profesional').value = p.id_profesional;
                                document.getElementById('nombre').value = p.nombre;
                                document.getElementById('apellido_pat').value = p.apellido_pat;
                                document.getElementById('apellido_mat').value = p.apellido_mat;
                                document.getElementById('correo').value = p.correo;
                                document.getElementById('cedula').value = p.cedula;
                                document.getElementById('especialidad').value = p.especialidad;

                                // quitar segundos del tiempo
                                document.getElementById('horario_inicio').value = p.horario_inicio.substring(0, 5);
                                document.getElementById('horario_fin').value = p.horario_fin.substring(0, 5);

                                // estado
                                document.getElementById('estado').value = (p.estado === 'Activo') ? '1' : '0';

                                // limpiar password
                                document.getElementById('password').value = '';

                                // cambiar título
                                document.querySelector('#modalPSalud .modal-title').textContent = "Editar Personal";

                                modalPSalud.show();
                            }

                            function mostrarToast(mensaje, tipo = 'success') {

                                const toastEl = document.getElementById('miToast');
                                const toastMensaje = document.getElementById('toastMensaje');

                                // limpiar colores anteriores
                                toastEl.classList.remove('bg-success', 'bg-danger', 'bg-warning', 'bg-info');

                                // asignar nuevo color
                                toastEl.classList.add(`bg-${tipo}`);

                                // mensaje dinámico
                                toastMensaje.textContent = mensaje;

                                // crear y mostrar toast
                                const toast = new bootstrap.Toast(toastEl);
                                toast.show();
                            }

                            function aplicarFiltros() {
                                const estadoFiltro = document.getElementById('filtroEstado').value;
                                const especialidadFiltro = document.getElementById('filtroEspecialidad').value;

                                let dataFiltrada = listaPersonalGlobal;

                                if (estadoFiltro) {
                                    dataFiltrada = listaPersonalGlobal.filter(p =>
                                        p.estado.toLowerCase() === estadoFiltro
                                    );
                                }
                                if (especialidadFiltro) {
                                    dataFiltrada = dataFiltrada.filter(p =>
                                        p.especialidad.toLowerCase() === especialidadFiltro
                                    );
                                }

                                recargarTabla(dataFiltrada);
                            }

                            function recargarTabla(data) {

                                //  validar antes de destruir
                                if (dataTable) {
                                    dataTable.destroy();
                                }

                                const table = document.querySelector('#tablaPersonal');
                                dataTable = new simpleDatatables.DataTable(table, {
                                    labels: {
                                        placeholder: "Busca nombre, cédula, correo...",
                                        noRows: "No hay datos disponibles",
                                        noResults: "No se encontraron resultados",
                                        info: "Mostrando {start} a {end} de {rows} registros"
                                    }
                                });
                                const mappedData = data.map(p => {
                                    const nombreCompleto = `${p.nombre} ${p.apellido_pat} ${p.apellido_mat}`;
                                    const horario = `${p.horario_inicio} - ${p.horario_fin}`;
                                    const estado = p.estado.toLowerCase();

                                    return [
                                        p.id_profesional,
                                        nombreCompleto,
                                        p.correo,
                                        p.especialidad,
                                        p.cedula,
                                        horario,
                                        `<span class="badge-status ${estado}">${p.estado}</span>`,
                                        `
                                        <button class="btn btn-sm btn-outline-success me-1" onclick="editar(${p.id_profesional})">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="eliminar(${p.id_profesional})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        `
                                    ];
                                });

                                // usar la variable correcta
                                dataTable.insert({
                                    data: mappedData
                                });
                            }

                            function cargarPersonal() {
                                fetch(`${API_BASE}/admin/pSalud/listar.php`)
                                    .then(res => res.json())
                                    .then(result => {

                                        if (result.status === 'success') {
                                            listaPersonalGlobal = result.data;
                                            recargarTabla(listaPersonalGlobal);
                                        } else {
                                            mostrarToast(result.message || 'Error al obtener datos', 'danger');
                                        }

                                    })
                                    .catch(err => {
                                        console.error(err);
                                        mostrarToast('Error al cargar el personal de salud', 'danger');
                                    });
                            }

                            function cargarStats() {
                                fetch(`${API_BASE}/admin/pSalud.php`)
                                    .then(res => res.json())
                                    .then(result => {

                                        if (result.status === 'success') {
                                            const data = result.data;

                                            document.getElementById('totalPersonal').textContent = data.total;
                                            document.getElementById('totalPacientes').textContent = data.activos;
                                            document.getElementById('totalCitas').textContent = data.inactivos;
                                        } else {
                                            mostrarToast('Error al obtener estadísticas', 'danger');
                                        }

                                    })
                                    .catch(err => {
                                        console.error('Error stats:', err);
                                        mostrarToast('Error al cargar estadísticas', 'danger');
                                    });
                            }
                        </script>


                        <!-- TABLA -->
                        <div class="card shadow-sm border-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Lista de Personal de Salud</h5>

                                <div class="d-flex gap-2">
                                    <select id="filtroEstado" class="form-select" style="width: 170px;">
                                        <option value="">Filtro por estado</option>
                                        <option value="activo">Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                    </select>

                                    <select id="filtroEspecialidad" class="form-select" style="width: 210px;">
                                        <option value="">Filtro por especialidad</option>
                                        <option value="medico">Médico</option>
                                        <option value="psicologo">Psicólogo</option>
                                        <option value="nutriologo">Nutriólogo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover" id="tablaPersonal">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Especialidad</th>
                                            <th>Cedula</th>
                                            <th>Horario</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
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
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script>
        // Constantes de rutas desde PHP
        const BACKEND_URL = '<?= BACKEND_URL ?>';
        const API_BASE = '<?= API_URL ?>';
        let listaPersonalGlobal = [];

        document.addEventListener('DOMContentLoaded', function() {
            cargarPersonal();
            cargarStats();
            document.getElementById('filtroEstado')
                .addEventListener('change', aplicarFiltros);

            document.getElementById('filtroEspecialidad')
                .addEventListener('change', aplicarFiltros);
            modalPSalud = new bootstrap.Modal(document.getElementById('modalPSalud'));
            document.getElementById('modalPSalud')
                .addEventListener('hidden.bs.modal', () => {

                    document.getElementById('formPSalud').reset();
                    document.getElementById('id_profesional').value = '';
                    document.querySelector('#modalPSalud .modal-title').textContent = "Nuevo Personal de Salud";

                });
        }); //aqui termina el D0MContentLoaded
    </script>
    <div class="toast-container position-fixed top-0 end-0 p-3">

        <div id="miToast" class="toast align-items-center text-white bg-success border-0" role="alert" data-bs-delay="3500">

            <div class="d-flex">
                <div class="toast-body" id="toastMensaje">
                    Mensaje aquí
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>

        </div>

    </div>
</body>

</html>