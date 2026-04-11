<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - UTMedic</title>

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

                    <h1 class="auth-title">Regístrate.</h1>
                    <p class="auth-subtitle">Ingresa tus datos para registrarte en el sistema.</p>

                    <form id="registerForm">
                        <div id="registerError" class="alert alert-danger d-none" role="alert"></div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <div class="form-control-icon" style="z-index: 2;">
                                    <i class="bi bi-person"></i>
                                </div>
                                <input type="text" class="form-control form-control-xl" id="regNombre" placeholder="Nombre(s)" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <div class="form-control-icon" style="z-index: 2;">
                                    <i class="bi bi-person"></i>
                                </div>
                                <input type="text" class="form-control form-control-xl" id="regApellido" placeholder="A. Paterno" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <div class="form-control-icon" style="z-index: 2;">
                                    <i class="bi bi-person"></i>
                                </div>
                                <input type="text" class="form-control form-control-xl" id="regApellidoMat" placeholder="A. Materno">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <input type="email" class="form-control form-control-xl" id="regCorreo" placeholder="Correo Electrónico" required>
                        </div>

                        <div class="form-group">
                            <div class="form-control-icon">
                                <i class="bi bi-card-text"></i>
                            </div>
                            <input type="text" class="form-control form-control-xl" id="regMatricula" placeholder="Matrícula" required>
                        </div>

                        <div class="form-group">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <input type="password" class="form-control form-control-xl" id="regPassword" placeholder="Contraseña" required>
                        </div>

                        <div class="form-group">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <input type="password" class="form-control form-control-xl" id="regConfirmPassword"
                                placeholder="Confirmar Contraseña" required>
                        </div>

                        <button type="submit" id="btnRegisterSubmit" class="btn btn-primary shadow-lg mt-2 w-100 fw-bold">Registrarse</button>
                    </form>

                    <div class="text-center mt-5">
                        <p class="text-secondary">¿Ya tienes una cuenta? <a href="auth-login.php">Inicia Sesión</a>.
                        </p>
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
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            e.preventDefault();
            
            const btn = document.getElementById('btnRegisterSubmit');
            const errorDiv = document.getElementById('registerError');
            errorDiv.classList.add('d-none');
            
            const data = {
                nombre: document.getElementById('regNombre').value,
                apellido_pat: document.getElementById('regApellido').value,
                apellido_mat: document.getElementById('regApellidoMat').value,
                correo: document.getElementById('regCorreo').value,
                matricula: document.getElementById('regMatricula').value,
                password: document.getElementById('regPassword').value,
                confirm_password: document.getElementById('regConfirmPassword').value
            };
            
            if (data.password !== data.confirm_password) {
                errorDiv.textContent = 'Las contraseñas no coinciden.';
                errorDiv.classList.remove('d-none');
                return;
            }
            
            btn.disabled = true;
            btn.innerText = 'Registrando...';
            
            fetch('../backend/api/registro.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(response => {
                if (response.status === 'success') {
                    // Simular notificación nativa de html por sweetalert si existiera, o usar alert basico
                    alert("¡Registro exitoso! Ya puedes iniciar sesión.");
                    window.location.href = 'auth-login.php';
                } else {
                    errorDiv.textContent = response.message || 'Error desconocido';
                    errorDiv.classList.remove('d-none');
                    btn.disabled = false;
                    btn.innerText = 'Registrarse';
                }
            })
            .catch(err => {
                errorDiv.textContent = 'Fallo de conexión al servidor.';
                errorDiv.classList.remove('d-none');
                btn.disabled = false;
                btn.innerText = 'Registrarse';
            });
        });
    </script>
</body>

</html>

