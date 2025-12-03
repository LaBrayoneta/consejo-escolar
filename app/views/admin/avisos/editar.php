<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/admin.css">
</head>
<body class="admin-page">
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>
    
    <div class="admin-content">
        <header class="admin-header">
            <h1>Editar Aviso</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="admin-container">
            <div class="form-card">
                <form method="POST" action="<?php echo BASE_URL; ?>admin/editar_aviso/<?php echo $aviso['id']; ?>" enctype="multipart/form-data">
                    <?php echo CSRF::insertTokenField(); ?>
                    
                    <div class="form-group">
                        <label for="titulo">Título *</label>
                        <input 
                            type="text" 
                            id="titulo" 
                            name="titulo" 
                            required 
                            maxlength="200"
                            value="<?php echo htmlspecialchars($aviso['titulo']); ?>"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="contenido">Contenido *</label>
                        <textarea 
                            id="contenido" 
                            name="contenido" 
                            rows="10" 
                            required
                        ><?php echo htmlspecialchars($aviso['contenido']); ?></textarea>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label>
                            <input 
                                type="checkbox" 
                                name="destacado" 
                                value="1"
                                <?php echo $aviso['destacado'] ? 'checked' : ''; ?>
                            >
                            <span>Marcar como destacado</span>
                        </label>
                        <small class="form-hint">Los avisos destacados aparecen en la página principal</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a href="<?php echo BASE_URL; ?>admin/avisos" class="btn btn-secondary">Cancelar</a>
                        <button 
                            type="button"
                            class="btn btn-danger"
                            onclick="confirmarEliminar(<?php echo $aviso['id']; ?>, '<?php echo htmlspecialchars($aviso['titulo'], ENT_QUOTES); ?>')"
                        >
                            Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmarEliminar(id, titulo) {
            if(confirm(`¿Estás seguro de eliminar el aviso "${titulo}"?\n\nEsta acción no se puede deshacer.`)) {
                window.location.href = '<?php echo BASE_URL; ?>admin/eliminar_aviso/' + id;
            }
        }
    </script>
</body>
</html>