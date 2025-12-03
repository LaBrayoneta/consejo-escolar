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
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <h1>Información Institucional</h1>
            </div>
            <div class="user-info">
                <span class="user-name">
                    <span class="user-icon">👤</span>
                    <?php echo htmlspecialchars($user['nombre']); ?>
                </span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary btn-sm">
                    <span>🚪</span> Cerrar Sesión
                </a>
            </div>
        </header>
        
        <div class="admin-container">
            <!-- Mensajes Flash -->
            <?php if($this->getFlash('success')): ?>
                <div class="alert alert-success">
                    ✓ <?php echo $this->getFlash('success'); ?>
                </div>
            <?php endif; ?>
            
            <?php if($this->getFlash('error')): ?>
                <div class="alert alert-error">
                    ✗ <?php echo $this->getFlash('error'); ?>
                </div>
            <?php endif; ?>

            <!-- Info Card -->
            <div class="info-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 24px; border-radius: 16px; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);">
                <h2 style="margin: 0 0 8px 0; font-size: 24px; font-weight: 800;">📋 Sobre esta sección</h2>
                <p style="margin: 0; opacity: 0.95; line-height: 1.6;">
                    Aquí puedes gestionar la información institucional que aparece en la página "Sobre Nosotros". 
                    Define la misión, visión, funciones y cualquier otra información relevante del Consejo Escolar.
                </p>
            </div>

            <!-- Stats -->
            <div class="stats-row">
                <div class="stat-card stat-primary">
                    <div class="stat-icon">📄</div>
                    <div class="stat-info">
                        <h3>Total Secciones</h3>
                        <p class="stat-number"><?php echo count($secciones); ?></p>
                    </div>
                </div>
                <div class="stat-card stat-success">
                    <div class="stat-icon">✓</div>
                    <div class="stat-info">
                        <h3>Activas</h3>
                        <p class="stat-number">
                            <?php echo count(array_filter($secciones, function($s) { return $s['activo']; })); ?>
                        </p>
                    </div>
                </div>
                <div class="stat-card stat-info">
                    <div class="stat-icon">👁️</div>
                    <div class="stat-info">
                        <h3>Vista Pública</h3>
                        <p class="stat-number">
                            <a href="<?php echo BASE_URL; ?>sobre-nosotros" target="_blank" style="color: var(--primary-color); text-decoration: none; font-size: 14px;">
                                Ver página →
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="🔍 Buscar secciones..." class="search-input">
                </div>
                <div class="actions-buttons">
                    <a href="<?php echo BASE_URL; ?>admin/informacion/crear" class="btn btn-primary">
                        <span>➕</span> Crear Nueva Sección
                    </a>
                </div>
            </div>
            
            <?php if(!empty($secciones)): ?>
                <div class="avisos-grid" id="seccionesGrid">
                    <?php foreach($secciones as $seccion): ?>
                        <div class="aviso-card-admin" data-status="<?php echo $seccion['activo'] ? 'active' : 'inactive'; ?>">
                            <div class="aviso-header-card">
                                <div class="aviso-badges">
                                    <span class="badge badge-info" style="background: linear-gradient(135deg, rgba(66, 153, 225, 0.15) 0%, rgba(49, 130, 206, 0.15) 100%); color: #3182ce; border: 2px solid rgba(66, 153, 225, 0.3);">
                                        🔖 <?php echo htmlspecialchars($seccion['seccion']); ?>
                                    </span>
                                    <?php if($seccion['activo']): ?>
                                        <span class="badge badge-success">✓ Activa</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">✗ Inactiva</span>
                                    <?php endif; ?>
                                </div>
                                <div class="aviso-id">#<?php echo $seccion['id']; ?></div>
                            </div>

                            <div class="aviso-body-card">
                                <h3 class="aviso-title"><?php echo htmlspecialchars($seccion['titulo']); ?></h3>
                                <p class="aviso-excerpt">
                                    <?php echo substr(strip_tags($seccion['contenido']), 0, 150) . '...'; ?>
                                </p>
                                
                                <div class="oficina-info-extra" style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--gray-200);">
                                    <p style="font-size: 13px; color: var(--text-secondary);">
                                        <strong>📊 Orden:</strong> <?php echo $seccion['orden']; ?>
                                    </p>
                                    <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                                        <strong>🕐 Actualizado:</strong> <?php echo date('d/m/Y H:i', strtotime($seccion['updated_at'])); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="aviso-footer-card">
                                <div class="aviso-meta">
                                    <span class="meta-item">
                                        <span class="meta-icon">📝</span>
                                        Sección institucional
                                    </span>
                                </div>
                                <div class="aviso-actions">
                                    <a href="<?php echo BASE_URL; ?>sobre-nosotros" 
                                       class="btn-icon btn-view" 
                                       title="Ver en sitio público"
                                       target="_blank">
                                        👁️
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>admin/informacion/editar/<?php echo $seccion['id']; ?>" 
                                       class="btn-icon btn-edit" 
                                       title="Editar">
                                        ✏️
                                    </a>
                                    <button onclick="confirmarEliminar(<?php echo $seccion['id']; ?>, '<?php echo htmlspecialchars($seccion['titulo'], ENT_QUOTES); ?>')" 
                                            class="btn-icon btn-delete" 
                                            title="Eliminar">
                                        🗑️
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="empty-search" id="emptySearch" style="display: none;">
                    <div class="empty-icon">🔍</div>
                    <h3>No se encontraron resultados</h3>
                    <p>Intenta con otros términos de búsqueda</p>
                </div>
            <?php else: ?>
                <div class="empty-state-admin">
                    <div class="empty-icon">📋</div>
                    <h3>No hay secciones todavía</h3>
                    <p>Comienza creando la primera sección de información institucional</p>
                    <a href="<?php echo BASE_URL; ?>admin/informacion/crear" class="btn btn-primary btn-lg">
                        <span>➕</span> Crear Primera Sección
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>js/admin.js"></script>
    <script>
        function confirmarEliminar(id, titulo) {
            if(confirm(`¿Estás seguro de eliminar la sección "${titulo}"?\n\nEsta acción no se puede deshacer.`)) {
                window.location.href = '<?php echo BASE_URL; ?>admin/informacion/eliminar/' + id;
            }
        }
    </script>
</body>
</html>