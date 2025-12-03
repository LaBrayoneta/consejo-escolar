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
            <h1>Editar Sección Institucional</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="admin-container">
            <div class="form-card">
                <!-- Current section info -->
                <div style="background: linear-gradient(135deg, var(--gray-50) 0%, white 100%); border: 2px solid var(--gray-200); padding: 20px; border-radius: 12px; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <span style="font-size: 24px;">📋</span>
                        <h3 style="margin: 0; color: var(--text-primary); font-size: 18px;">
                            Editando: <?php echo htmlspecialchars($seccion['titulo']); ?>
                        </h3>
                    </div>
                    <p style="margin: 0; color: var(--text-muted); font-size: 13px;">
                        <strong>ID:</strong> #<?php echo $seccion['id']; ?> | 
                        <strong>Identificador:</strong> <?php echo htmlspecialchars($seccion['seccion']); ?>
                    </p>
                </div>

                <form method="POST" action="<?php echo BASE_URL; ?>admin/informacion/editar/<?php echo $seccion['id']; ?>">
                    <?php echo CSRF::insertTokenField(); ?>
                    
                    <div class="form-group">
                        <label for="seccion">Identificador de Sección *</label>
                        <input 
                            type="text" 
                            id="seccion" 
                            name="seccion" 
                            required 
                            maxlength="50"
                            value="<?php echo htmlspecialchars($seccion['seccion']); ?>"
                            pattern="[a-z0-9_-]+"
                            title="Solo letras minúsculas, números, guiones y guiones bajos"
                        >
                        <small class="form-hint">
                            Identificador único en minúsculas, sin espacios
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
                            value="<?php echo htmlspecialchars($seccion['titulo']); ?>"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="contenido">Contenido *</label>
                        <textarea 
                            id="contenido" 
                            name="contenido" 
                            rows="12" 
                            required
                        ><?php echo htmlspecialchars($seccion['contenido']); ?></textarea>
                        <small class="form-hint">
                            Caracteres: <span id="charCount">0</span> | Palabras: <span id="wordCount">0</span>
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="orden">Orden de visualización</label>
                        <input 
                            type="number" 
                            id="orden" 
                            name="orden"
                            value="<?php echo $seccion['orden']; ?>"
                            min="0"
                        >
                        <small class="form-hint">
                            Define el orden en que aparecerá esta sección (menor número = primero)
                        </small>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="activo" value="1" <?php echo $seccion['activo'] ? 'checked' : ''; ?>>
                            <span>Sección activa</span>
                        </label>
                        <small class="form-hint">
                            Las secciones inactivas no se muestran en el sitio público
                        </small>
                    </div>

                    <!-- Metadata -->
                    <div style="background: var(--gray-50); padding: 16px; border-radius: 8px; margin: 24px 0;">
                        <h4 style="margin: 0 0 12px 0; color: var(--text-secondary); font-size: 14px; font-weight: 700;">
                            📊 Metadatos
                        </h4>
                        <div style="display: grid; gap: 8px; font-size: 13px; color: var(--text-muted);">
                            <p style="margin: 0;">
                                <strong>Última actualización:</strong> 
                                <?php echo date('d/m/Y H:i:s', strtotime($seccion['updated_at'])); ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a href="<?php echo BASE_URL; ?>admin/informacion" class="btn btn-secondary">Cancelar</a>
                        <button 
                            type="button"
                            class="btn btn-danger"
                            onclick="confirmarEliminar(<?php echo $seccion['id']; ?>, '<?php echo htmlspecialchars($seccion['titulo'], ENT_QUOTES); ?>')"
                        >
                            Eliminar
                        </button>
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

        // Contador de caracteres y palabras
        const contenidoTextarea = document.getElementById('contenido');
        const charCount = document.getElementById('charCount');
        const wordCount = document.getElementById('wordCount');

        function updateCounts() {
            const text = contenidoTextarea.value;
            charCount.textContent = text.length;
            const words = text.trim().split(/\s+/).filter(w => w.length > 0);
            wordCount.textContent = words.length;
        }

        contenidoTextarea.addEventListener('input', updateCounts);
        updateCounts(); // Initial count

        function confirmarEliminar(id, titulo) {
            if(confirm(`¿Estás seguro de eliminar la sección "${titulo}"?\n\nEsta acción no se puede deshacer.`)) {
                window.location.href = '<?php echo BASE_URL; ?>admin/informacion/eliminar/' + id;
            }
        }
    </script>
</body>
</html>