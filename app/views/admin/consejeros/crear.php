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
            <h1>Crear Nuevo Consejero</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="admin-container">
            <div class="form-card">
                <form method="POST" action="<?php echo BASE_URL; ?>admin/consejeros/crear" enctype="multipart/form-data">
                    <?php echo CSRF::insertTokenField(); ?>
                    
                    <div class="form-group">
                        <label for="nombre">Nombre Completo *</label>
                        <input 
                            type="text" 
                            id="nombre" 
                            name="nombre" 
                            required 
                            maxlength="100"
                            placeholder="Ej: Juan Pérez"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="cargo">Cargo *</label>
                        <input 
                            type="text" 
                            id="cargo" 
                            name="cargo" 
                            required 
                            maxlength="100"
                            placeholder="Ej: Presidente del Consejo Escolar"
                        >
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto del Consejero</label>
                        <input 
                            type="file" 
                            id="foto" 
                            name="foto"
                            accept="image/jpeg,image/png,image/jpg"
                        >
                        <small class="form-hint">Formatos permitidos: JPG, PNG. Máximo 2MB</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="biografia">Biografía</label>
                        <textarea 
                            id="biografia" 
                            name="biografia" 
                            rows="6"
                            placeholder="Breve biografía o información relevante del consejero"
                        ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            placeholder="consejero@consejoescolar.gob.ar"
                        >
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input 
                            type="tel" 
                            id="telefono" 
                            name="telefono"
                            placeholder="(0291) 123-4567"
                        >
                    </div>

                    <div class="form-group">
                        <label for="orden">Orden de visualización</label>
                        <input 
                            type="number" 
                            id="orden" 
                            name="orden"
                            value="0"
                            min="0"
                        >
                        <small class="form-hint">Orden en que aparecerá en el sitio (menor número = primero)</small>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="activo" value="1" checked>
                            <span>Consejero activo</span>
                        </label>
                        <small class="form-hint">Los consejeros inactivos no se muestran en el sitio público</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Crear Consejero</button>
                        <a href="<?php echo BASE_URL; ?>admin/consejeros" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>