?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Consejo Escolar</title>
    <link rel="stylesheet" href="/views/assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h1>Consejo Escolar</h1>
                <h2>Iniciar Sesión</h2>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="/auth/login" class="auth-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Ingresar</button>
            </form>
            
            <div class="auth-footer">
                <p>¿No tenés cuenta? <a href="/auth/register">Registrate aquí</a></p>
                <p><a href="/">Volver al inicio</a></p>
            </div>
        </div>
    </div>
</body>
</html>