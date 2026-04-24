<!DOCTYPE html>
<?php require_once '../../backend/config/paths.php'; ?>
<html lang="es">

<head>
    <link rel="shortcut icon" type="image/x-icon" href="/UTMedic-Web/template/dist/frontend/assets/compiled/png/utmedic.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UTMedic</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/utmedic-global.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/utmedic-auth.css?v=<?= time() ?>">
    <style>
        /* Fondo mejorado */
        body {
            background: linear-gradient(135deg, #e8f4f5 0%, #d1e8ea 100%);
            min-height: 100vh;
        }

        #auth-left {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            margin: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 84, 97, 0.1);
        }

        #auth-right {
            background: linear-gradient(135deg, var(--utm-primary) 0%, var(--utm-secondary) 50%, var(--utm-accent) 100%);
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* Patrón de puntos decorativo en el lado derecho */
        #auth-right::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        /* Mejorar el formulario */
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-control-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }

        .form-control-icon i {
            font-size: 1.1rem;
            color: #000000;
        }

        .form-control {
            padding-left: 45px !important;
            border-radius: 12px !important;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
            height: 52px;
        }

        .form-control:focus {
            border-color: var(--utm-secondary);
            box-shadow: 0 0 0 3px rgba(1, 135, 144, 0.1);
        }

        /* Estilos específicos para el password-wrapper */
        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .password-wrapper .form-control {
            padding-right: 50px !important;
        }

        .password-wrapper .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            background: transparent;
            border: none;
            z-index: 10;
            padding: 8px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-wrapper .toggle-password i {
            font-size: 1.2rem;
            color: #6c757d;
        }

        .password-wrapper .toggle-password:hover i {
            color: var(--utm-secondary);
        }

        .btn-primary {
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0">

            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="mb-4">
                        <span style="font-weight: 800; font-size: 2rem; color: var(--utm-secondary);">UTMedic</span>
                    </div>

                    <h1 class="auth-title">Bienvenido.</h1>
                    <p class="auth-subtitle">Ingresa tus datos para acceder al sistema.</p>

                    <!-- DIV para mostrar errores -->
                    <div id="loginError" class="alert alert-danger d-none" role="alert"></div>

                    <form id="loginForm">
                        <div class="form-group">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <input type="text" name="email" id="emailInput" class="form-control form-control-xl"
                                placeholder="Matrícula o Email" required>
                        </div>

                        <div class="form-group mb-4">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <div class="password-wrapper">
                                <input type="password" name="password" id="passwordInput" class="form-control form-control-xl"
                                    placeholder="Contraseña" required>
                                <button type="button" class="toggle-password" id="togglePasswordBtn">
                                    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <button id="btnSubmit" type="submit" class="btn btn-primary shadow-lg w-100 mt-2">Iniciar Sesión</button>
                    </form>

                    <div class="text-center mt-3">
                        <p class="text-secondary">¿No tienes cuenta? <a href="auth-register.php">Regístrate</a>.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ========== MOSTRAR/OCULTAR CONTRASEÑA ==========
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('passwordInput');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (togglePasswordBtn && passwordInput) {
            togglePasswordBtn.addEventListener('click', function() {
                // Cambiar el tipo de input
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Cambiar el ícono
                if (type === 'text') {
                    toggleIcon.classList.remove('bi-eye-slash');
                    toggleIcon.classList.add('bi-eye');
                } else {
                    toggleIcon.classList.remove('bi-eye');
                    toggleIcon.classList.add('bi-eye-slash');
                }
            });
        }

        // ========== LOGIN ==========
        // Constantes de rutas desde PHP
        const BACKEND_URL = '<?= BACKEND_URL ?>';
        const API_URL = '<?= API_URL ?>';

        // Lógica para enviar el formulario estándar
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Evita recargar la página

            const btnSubmit = document.getElementById('btnSubmit');
            const originalText = btnSubmit.innerText;
            btnSubmit.innerText = 'Cargando...';
            btnSubmit.disabled = true;

            const formData = new FormData(this);

            fetch(`${BACKEND_URL}/login.php`, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    btnSubmit.innerText = originalText;
                    btnSubmit.disabled = false;

                    if (data.status === 'success') {
                        window.location.href = data.redirect;
                    } else {
                        showLoginError(data.message);
                    }
                })
                .catch(error => {
                    btnSubmit.innerText = originalText;
                    btnSubmit.disabled = false;
                    console.error('Error Login Normal:', error);
                    showLoginError('Error de conexión con el servidor.');
                });
        });

        function showLoginError(msg) {
            const errorDiv = document.getElementById('loginError');
            errorDiv.innerText = msg;
            errorDiv.classList.remove('d-none');
        }
    </script>
</body>

</html>