<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Admin</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/login.css">
</head>
<body>
    <div class="bg-animation">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <div class="logo-icon">🏫</div>
                <h1>Consejo Escolar</h1>
                <p>Panel de Administración</p>
            </div>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo BASE_URL; ?>admin/login" id="loginForm">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            required 
                            autofocus
                            autocomplete="username"
                        >
                        <span class="input-icon">👤</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            autocomplete="current-password"
                        >
                        <span class="input-icon">🔒</span>
                        <button type="button" class="password-toggle" id="togglePassword">
                            👁️
                        </button>
                    </div>
                </div>

                <div class="remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Recordarme</span>
                    </label>
                    <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                </div>
                
                <button type="submit" class="btn">
                    <span>Iniciar Sesión</span>
                </button>
            </form>
            
            <div class="login-footer">
                <a href="<?php echo BASE_URL; ?>">
                    ← Volver al sitio
                </a>
            </div>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>js/login.js"></script>
</body>
</html>