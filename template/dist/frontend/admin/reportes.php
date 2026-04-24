<?php
header('Content-Type: text/html; charset=utf-8');
// Importar el escudo protector de rutas validando que sea Administrador
require_once __DIR__ . '/../../backend/auth_admin.php';
require_once __DIR__ . '/../../backend/config/paths.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTMedic - Panel de Reportes</title>

    <link rel="shortcut icon"
        href="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%2033%2034'%20fill-rule='evenodd'%20stroke-linejoin='round'%20stroke-miterlimit='2'%20xmlns:v='https://vecta.io/nano'%3e%3cpath%20d='M3%2027.472c0%204.409%206.18%205.552%2013.5%205.552%207.281%200%2013.5-1.103%2013.5-5.513s-6.179-5.552-13.5-5.552c-7.281%200-13.5%201.103-13.5%205.513z'%20fill='%23435ebe'%20fill-rule='nonzero'/%3e%3ccircle%20cx='16.5'%20cy='8.8'%20r='8.8'%20fill='%2341bbdd'/%3e%3c/svg%3e"
        type="image/x-icon">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/table-datatable.css">
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/app.css">
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="assets/css/utmedic-global.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/utmedic-dashboard.css?v=<?= time() ?>">

    <!-- Bootstrap Icons (necesario para los iconos) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
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
                                <input class="form-check-input me-0" type="checkbox" id="toggle-dark"
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
                        <div class="sidebar-toggler x">
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
                                <span>Cerrar Sesion</span>
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

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Panel de Reportes</h3>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <section class="section">
                    <div class="row mb-4">
                        <!-- Tarjeta 1: Total Citas -->
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon icon-card mb-2">
                                                <i class="bi bi-calendar-check-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total Citas</h6>
                                            <h6 class="font-extrabold mb-0" id="totalCitas">0</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta 3: Canceladas -->
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon icon-card mb-2">
                                                <i class="bi bi-x-circle-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Citas Canceladas</h6>
                                            <h6 class="font-extrabold mb-0" id="totalCanceladas">0</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta 4: Emergencias -->
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon icon-card mb-2">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total Emergencias</h6>
                                            <h6 class="font-extrabold mb-0" id="totalEmergencias">0</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tarjeta 5: Tasa de Asistencia -->
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon icon-card mb-2">
                                                <i class="bi bi-graph-up"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Tasa Asistencia</h6>
                                            <h6 class="font-extrabold mb-0" id="tasaAsistencia">0%</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

                <!-- Aqui iran las graficas mas adelante -->
                <section class="section">
                    <div class="row g-4"> <!--  gap automático -->

                        <div class="col-12 col-lg-6">
                            <div class="card p-3">
                                <div id="chartEstados"></div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="card p-3">
                                <div id="chartEspecialidades"></div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="card p-3">
                                <div id="chartCarreras"></div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="card p-3">
                                <div id="chartCuatrimestres"></div>
                            </div>
                        </div>

                    </div>
                </section>

            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted pb-4">
                    <div class="float-start">
                        <p>2024 &copy; UTMedic - Sistema de Gestion de Citas Medicas</p>
                    </div>
                    <div class="float-end">
                        <p>Universidad Tecnologica de Morelia</p>
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
        // RUTAS DESDE PHP
        const BACKEND_URL = '<?= BACKEND_URL ?>';
        const API_BASE = '<?= API_URL ?>';

        function cargarKPIs() {

            fetch(`${API_BASE}/admin/reportes/kpis.php`)
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(result => {

                    if (result.status === 'success') {
                        const data = result.data;

                        document.getElementById('totalCitas').textContent = data.total_citas || 0;
                        document.getElementById('totalCanceladas').textContent = data.canceladas || 0;
                        document.getElementById('totalEmergencias').textContent = data.emergencias || 0;
                        document.getElementById('tasaAsistencia').textContent = (data.tasa_asistencia || 0) + '%';
                        cargarGraficas(data);
                    } else {
                        console.error('Error del servidor:', result.message);
                    }
                })
                .catch(err => {
                    console.error('Error en fetch KPIs:', err);
                    // Mostrar valores por defecto en caso de error
                    document.getElementById('totalCitas').textContent = 'Error';
                    document.getElementById('totalCanceladas').textContent = 'Error';
                    document.getElementById('totalEmergencias').textContent = 'Error';
                    document.getElementById('tasaAsistencia').textContent = 'Error%';
                });
        }

        function cargarGraficas(data) {
            console.log(data);

            document.getElementById('chartEstados').innerHTML = '';

            var optionsEstados = {
                chart: {
                    type: 'polarArea',
                },
                grid: {
                    show: false
                },
                series: [
                    data.atendidas || 0,
                    data.agendadas || 0,
                    data.canceladas || 0,
                    data.emergencias || 0
                ],
                labels: ['Atendidas', 'Agendadas', 'Canceladas', 'Emergencias'],
                yaxis: {
                    stepSize: 1,    
                    labels: {
                        formatter: function(val) {
                            return Math.floor(val); // O simplemente return val.toFixed(0);
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val, opts) {
                        return opts.w.globals.series[opts.seriesIndex];
                    }
                },
                title: {
                    text: 'Citas por Estado',
                    align: 'center'
                }
            };

            var chartEstados = new ApexCharts(
                document.querySelector("#chartEstados"),
                optionsEstados
            );

            chartEstados.render();
        }

        function cargarEspecialidades() {

            document.getElementById('chartEspecialidades').innerHTML = '';

            fetch(`${API_BASE}/admin/reportes/especialidades.php`)
                .then(res => res.json())
                .then(result => {

                    const data = result.data;

                    const nombres = data.map(e => {
                        if (e.especialidad === 'medico') return 'Médico';
                        if (e.especialidad === 'psicologo') return 'Psicólogo';
                        if (e.especialidad === 'nutriologo') return 'Nutriólogo';
                    });
                    const totales = data.map(e => e.total);
                    const estilos = getComputedStyle(document.documentElement);

                    const colores = [
                        estilos.getPropertyValue('--utm-primary').trim(),
                        estilos.getPropertyValue('--utm-secondary').trim(),
                        estilos.getPropertyValue('--utm-accent').trim()
                    ];
                    var options = {
                        chart: {
                            type: 'bar'
                        },
                        series: [{
                            name: 'Citas',
                            data: totales
                        }],
                        colors: colores,
                        xaxis: {
                            categories: nombres
                        },
                        yaxis: {
                            min: 0,
                            forceNiceScale: true,
                            labels: {
                                formatter: function(val) {
                                    return parseInt(val);
                                }
                            }
                        },
                        title: {
                            text: 'Citas por Especialidad',
                            align: 'center'
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chartEspecialidades"), options);
                    chart.render();
                });
        }

        function cargarCarreras() {

            document.getElementById('chartCarreras').innerHTML = '';

            fetch(`${API_BASE}/admin/reportes/carreras.php`)
                .then(res => res.json())
                .then(result => {

                    const data = result.data;

                    const nombres = data.map(e => e.carrera);
                    const totales = data.map(e => parseInt(e.total));

                    const max = Math.max(...totales);

                    const estilos = getComputedStyle(document.documentElement);

                    const colorTop = estilos.getPropertyValue('--utm-secondary').trim();
                    const colorNormal = estilos.getPropertyValue('--utm-accent').trim();

                    const colores = totales.map(valor =>
                        valor === max ? colorTop : colorNormal
                    );

                    var options = {
                        chart: {
                            type: 'bar'
                        },
                        series: [{
                            name: 'Citas',
                            data: totales
                        }],
                        xaxis: {
                            categories: nombres
                        },
                        colors: colores,
                        plotOptions: {
                            bar: {
                                distributed: true,
                                columnWidth: '55%'
                            }
                        },
                        dataLabels: {
                            enabled: true
                        },
                        markers: {
                            size: 6
                        },
                        yaxis: {
                            min: 0,
                            forceNiceScale: true,
                            labels: {
                                formatter: function(val) {
                                    return parseInt(val);
                                }
                            }
                        },
                        title: {
                            text: 'Top Carreras con Más Citas',
                            align: 'center'
                        }
                    };

                    var chart = new ApexCharts(
                        document.querySelector("#chartCarreras"),
                        options
                    );

                    chart.render();
                });
        }

        function cargarCuatrimestres() {

            document.getElementById('chartCuatrimestres').innerHTML = '';

            fetch(`${API_BASE}/admin/reportes/cuatrimestres.php`)
                .then(res => res.json())
                .then(result => {

                    const data = result.data;

                    const nombres = data.map(e => e.cuatrimestre);
                    const totales = data.map(e => e.total);

                    var options = {
                        chart: {
                            type: 'line',
                            toolbar: {
                                show: false
                            }
                        },
                        series: [{
                            name: 'Citas',
                            data: totales
                        }],
                        yaxis: {
                            min: 0,
                            forceNiceScale: true,
                            labels: {
                                formatter: function(val) {
                                    return parseInt(val);
                                }
                            }
                        },
                        xaxis: {
                            categories: nombres
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        dataLabels: {
                            enabled: true
                        },
                        title: {
                            text: 'Citas por Cuatrimestre',
                            align: 'center'
                        }
                    };

                    var chart = new ApexCharts(
                        document.querySelector("#chartCuatrimestres"),
                        options
                    );

                    chart.render();
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            cargarKPIs();
            cargarEspecialidades();
            cargarCarreras();
            cargarCuatrimestres();
        });
    </script>
</body>

</html>