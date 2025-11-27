<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/admin.css">
</head>
<body class="admin-page">
    <?php include '../app/views/admin/partials/sidebar.php'; ?>
    
    <div class="admin-content">
        <header class="admin-header">
            <h1>Crear Nuevo Aviso</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="admin-container">
            <div class="form-card">
                <form method="POST" action="<?php echo BASE_URL; ?>admin/crear_aviso" enctype="multipart/form-data">
                    <?php echo CSRF::insertTokenField(); ?>
                    
                    <div class="form-group">
                        <label for="titulo">Título *</label>
                        <input 
                            type="text" 
                            id="titulo" 
                            name="titulo" 
                            required 
                            maxlength="200"
                            placeholder="Ingrese el título del aviso"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="contenido">Contenido *</label>
                        <textarea 
                            id="contenido" 
                            name="contenido" 
                            rows="10" 
                            required
                            placeholder="Escriba el contenido del aviso"
                        ></textarea>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="destacado" value="1">
                            <span>Marcar como destacado</span>
                        </label>
                        <small class="form-hint">Los avisos destacados aparecen en la página principal</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Crear Aviso</button>
                        <a href="<?php echo BASE_URL; ?>admin/avisos" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>