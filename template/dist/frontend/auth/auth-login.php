<!DOCTYPE html>
<?php require_once '../../backend/config/paths.php'; ?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UTMedic</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/utmedic-global.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/utmedic-auth.css?v=<?= time() ?>">
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
                            <input type="password" name="password" id="passwordInput" class="form-control form-control-xl"
                                placeholder="Contraseña" required>
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

