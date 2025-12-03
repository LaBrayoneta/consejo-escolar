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
            <h1>Crear Sección Institucional</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="admin-container">
            <div class="form-card">
                <!-- Info helper -->
                <div style="background: linear-gradient(135deg, rgba(66, 153, 225, 0.1) 0%, rgba(49, 130, 206, 0.05) 100%); border-left: 4px solid #3182ce; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                    <h3 style="margin: 0 0 8px 0; color: #2c5282; font-size: 16px;">💡 Sugerencias de secciones</h3>
                    <ul style="margin: 0; padding-left: 20px; color: #4a5568; font-size: 14px; line-height: 1.8;">
                        <li><strong>misión:</strong> La misión del Consejo Escolar</li>
                        <li><strong>visión:</strong> La visión institucional</li>
                        <li><strong>funciones:</strong> Funciones principales del organismo</li>
                        <li><strong>historia:</strong> Historia y trayectoria</li>
                        <li><strong>valores:</strong> Valores institucionales</li>
                    </ul>
                </div>

                <form method="POST" action="<?php echo BASE_URL; ?>admin/informacion/crear">
                    <?php echo CSRF::insertTokenField(); ?>
                    
                    <div class="form-group">
                        <label for="seccion">Identificador de Sección *</label>
                        <input 
                            type="text" 
                            id="seccion" 
                            name="seccion" 
                            required 
                            maxlength="50"
                            placeholder="Ej: mision, vision, funciones"
                            pattern="[a-z0-9_-]+"
                            title="Solo letras minúsculas, números, guiones y guiones bajos"
                        >
                        <small class="form-hint">
                            Identificador único en minúsculas, sin espacios. Ej: mision, vision, funciones
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <label for="titulo">Título *</label>
                        <input 
                            type="text" 
                            id="titulo" 
                            name="titulo" 
                            required 
                            maxlength="200"
                            placeholder="Ej: Nuestra Misión"
                        >
                        <small class="form-hint">
                            Título que se mostrará en la página pública
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <label for="contenido">Contenido *</label>
                        <textarea 
                            id="contenido" 
                            name="contenido" 
                            rows="12" 
                            required
                            placeholder="Escribe el contenido de esta sección..."
                        ></textarea>
                        <small class="form-hint">
                            Puedes usar saltos de línea. El texto se mostrará tal como lo escribas.
                        </small>
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
                        <small class="form-hint">
                            Define el orden en que aparecerá esta sección (menor número = primero)
                        </small>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="activo" value="1" checked>
                            <span>Sección activa</span>
                        </label>
                        <small class="form-hint">
                            Las secciones inactivas no se muestran en el sitio público
                        </small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Crear Sección</button>
                        <a href="<?php echo BASE_URL; ?>admin/informacion" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Convertir a slug el identificador de sección
        document.getElementById('seccion').addEventListener('input', function(e) {
            this.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9_-]/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
        });

        // Auto-generar identificador desde el título si está vacío
        document.getElementById('titulo').addEventListener('input', function(e) {
            const seccionInput = document.getElementById('seccion');
            if (seccionInput.value === '') {
                const slug = this.value
                    .toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-|-$/g, '');
                seccionInput.value = slug;
            }
        });
    </script>
</body>
</html>