<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - UTMedic</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="assets/css/utmedic-global.css?v=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/utmedic-auth.css?v=<?= time() ?>">
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="mb-4">
                        <span style="font-weight: 800; font-size: 2rem; color: var(--utm-secondary);">UTMedic</span>
                    </div>

                    <h1 class="auth-title">Recuperar Contraseña.</h1>
                    <p class="auth-subtitle mb-5">Ingresa tu correo electrónico y te enviaremos un enlace para
                        restablecer tu contraseña.</p>

                    <form action="auth-login.html" id="forgotPasswordForm">
                        <div class="form-group mb-4">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <input type="email" class="form-control form-control-xl" placeholder="Correo Electrónico"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary shadow-lg mt-2">Enviar Enlace</button>
                    </form>

                    <div class="text-center mt-5">
                        <p class="text-secondary">¿Recuerdas tu contraseña? <a href="auth-login.php">Inicia Sesión</a>.
                        </p>
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
        document.getElementById('forgotPasswordForm').addEventListener('submit', function (e) {
            e.preventDefault();
            alert("Enlace de recuperación enviado. Por favor, revisa tu correo electrónico.");
            window.location.href = 'auth-login.php';
        });
    </script>
</body>

</html>

