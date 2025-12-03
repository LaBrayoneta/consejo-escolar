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
            <h1>Editar Institución</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="admin-container">
            <div class="form-card">
                <form method="POST" action="<?php echo BASE_URL; ?>admin/instituciones/editar/<?php echo $institucion['id']; ?>">
                    <?php echo CSRF::insertTokenField(); ?>
                    
                    <div class="form-group">
                        <label for="nombre">Nombre de la Institución *</label>
                        <input 
                            type="text" 
                            id="nombre" 
                            name="nombre" 
                            required 
                            maxlength="200"
                            value="<?php echo htmlspecialchars($institucion['nombre']); ?>"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="nivel">Nivel Educativo *</label>
                        <select id="nivel" name="nivel" required>
                            <option value="">-- Seleccione un nivel --</option>
                            <option value="Inicial" <?php echo $institucion['nivel'] === 'Inicial' ? 'selected' : ''; ?>>Inicial</option>
                            <option value="Primaria" <?php echo $institucion['nivel'] === 'Primaria' ? 'selected' : ''; ?>>Primaria</option>
                            <option value="Secundaria" <?php echo $institucion['nivel'] === 'Secundaria' ? 'selected' : ''; ?>>Secundaria</option>
                            <option value="Superior" <?php echo $institucion['nivel'] === 'Superior' ? 'selected' : ''; ?>>Superior</option>
                            <option value="Especial" <?php echo $institucion['nivel'] === 'Especial' ? 'selected' : ''; ?>>Especial</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input 
                            type="text" 
                            id="direccion" 
                            name="direccion"
                            maxlength="200"
                            value="<?php echo htmlspecialchars($institucion['direccion'] ?? ''); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input 
                            type="tel" 
                            id="telefono" 
                            name="telefono"
                            maxlength="20"
                            value="<?php echo htmlspecialchars($institucion['telefono'] ?? ''); ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            maxlength="100"
                            value="<?php echo htmlspecialchars($institucion['email'] ?? ''); ?>"
                        >
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="activo" value="1" <?php echo $institucion['activo'] ? 'checked' : ''; ?>>
                            <span>Institución activa</span>
                        </label>
                        <small class="form-hint">Las instituciones inactivas no se muestran en el sitio público</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a href="<?php echo BASE_URL; ?>admin/instituciones" class="btn btn-secondary">Cancelar</a>
                        <button 
                            type="button"
                            class="btn btn-danger"
                            onclick="confirmarEliminar(<?php echo $institucion['id']; ?>, '<?php echo htmlspecialchars($institucion['nombre'], ENT_QUOTES); ?>')"
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
            if(confirm(`¿Estás seguro de eliminar la institución "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
                window.location.href = '<?php echo BASE_URL; ?>admin/instituciones/eliminar/' + id;
            }
        }
    </script>
</body>
</html>