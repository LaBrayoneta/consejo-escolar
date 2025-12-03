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
            <h1>Crear Nueva Institución</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="admin-container">
            <div class="form-card">
                <form method="POST" action="<?php echo BASE_URL; ?>admin/instituciones/crear">
                    <?php echo CSRF::insertTokenField(); ?>
                    
                    <div class="form-group">
                        <label for="nombre">Nombre de la Institución *</label>
                        <input 
                            type="text" 
                            id="nombre" 
                            name="nombre" 
                            required 
                            maxlength="200"
                            placeholder="Ej: Escuela Primaria N° 1"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="nivel">Nivel Educativo *</label>
                        <select id="nivel" name="nivel" required>
                            <option value="">-- Seleccione un nivel --</option>
                            <option value="Inicial">Inicial</option>
                            <option value="Primaria">Primaria</option>
                            <option value="Secundaria">Secundaria</option>
                            <option value="Superior">Superior</option>
                            <option value="Especial">Especial</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input 
                            type="text" 
                            id="direccion" 
                            name="direccion"
                            maxlength="200"
                            placeholder="Ej: Calle Falsa 123"
                        >
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input 
                            type="tel" 
                            id="telefono" 
                            name="telefono"
                            maxlength="20"
                            placeholder="(0291) 123-4567"
                        >
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            maxlength="100"
                            placeholder="escuela@ejemplo.edu.ar"
                        >
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="activo" value="1" checked>
                            <span>Institución activa</span>
                        </label>
                        <small class="form-hint">Las instituciones inactivas no se muestran en el sitio público</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Crear Institución</button>
                        <a href="<?php echo BASE_URL; ?>admin/instituciones" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>