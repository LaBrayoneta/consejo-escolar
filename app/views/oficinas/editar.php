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
            <h1>Editar Oficina</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="admin-container">
            <div class="form-card">
                <form method="POST" action="<?php echo BASE_URL; ?>admin/oficinas/editar/<?php echo $oficina['id']; ?>">
                    <?php echo CSRF::insertTokenField(); ?>
                    
                    <div class="form-group">
                        <label for="nombre">Nombre de la Oficina *</label>
                        <input 
                            type="text" 
                            id="nombre" 
                            name="nombre" 
                            required 
                            maxlength="100"
                            value="<?php echo htmlspecialchars($oficina['nombre']); ?>"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="descripcion">Descripción *</label>
                        <textarea 
                            id="descripcion" 
                            name="descripcion" 
                            rows="4" 
                            required
                        ><?php echo htmlspecialchars($oficina['descripcion']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="funciones">Funciones *</label>
                        <textarea 
                            id="funciones" 
                            name="funciones" 
                            rows="6" 
                            required
                        ><?php echo htmlspecialchars($oficina['funciones']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="email_principal">Email Principal *</label>
                        <input 
                            type="email" 
                            id="email_principal" 
                            name="email_principal" 
                            required
                            value="<?php echo htmlspecialchars($oficina['email_principal']); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="email_secundario">Email Secundario</label>
                        <input 
                            type="email" 
                            id="email_secundario" 
                            name="email_secundario"
                            value="<?php echo htmlspecialchars($oficina['email_secundario'] ?? ''); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input 
                            type="tel" 
                            id="telefono" 
                            name="telefono"
                            value="<?php echo htmlspecialchars($oficina['telefono'] ?? ''); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="ubicacion">Ubicación</label>
                        <input 
                            type="text" 
                            id="ubicacion" 
                            name="ubicacion"
                            value="<?php echo htmlspecialchars($oficina['ubicacion'] ?? ''); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="orden">Orden de visualización</label>
                        <input 
                            type="number" 
                            id="orden" 
                            name="orden"
                            value="<?php echo $oficina['orden']; ?>"
                            min="0"
                        >
                        <small class="form-hint">Orden en que aparecerá en el sitio (menor número = primero)</small>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="activo" value="1" <?php echo $oficina['activo'] ? 'checked' : ''; ?>>
                            <span>Oficina activa</span>
                        </label>
                        <small class="form-hint">Las oficinas inactivas no se muestran en el sitio público</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a href="<?php echo BASE_URL; ?>admin/oficinas" class="btn btn-secondary">Cancelar</a>
                        <button 
                            type="button"
                            class="btn btn-danger"
                            onclick="confirmarEliminar(<?php echo $oficina['id']; ?>, '<?php echo htmlspecialchars($oficina['nombre'], ENT_QUOTES); ?>')"
                        >
                            Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmarEliminar(id, nombre) {
            if(confirm(`¿Estás seguro de eliminar la oficina "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
                window.location.href = '<?php echo BASE_URL; ?>admin/oficinas/eliminar/' + id;
            }
        }
    </script>
</body>
</html>