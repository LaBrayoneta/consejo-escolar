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
                <h1>Gestionar Instituciones</h1>
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
            <!-- Stats Cards -->
            <div class="stats-row">
                <div class="stat-card stat-primary">
                    <div class="stat-icon">🏫</div>
                    <div class="stat-info">
                        <h3>Total Instituciones</h3>
                        <p class="stat-number"><?php echo count($instituciones); ?></p>
                    </div>
                </div>
                <div class="stat-card stat-success">
                    <div class="stat-icon">✓</div>
                    <div class="stat-info">
                        <h3>Activas</h3>
                        <p class="stat-number">
                            <?php echo count(array_filter($instituciones, function($i) { return $i['activo']; })); ?>
                        </p>
                    </div>
                </div>
                <div class="stat-card stat-warning">
                    <div class="stat-icon">👔</div>
                    <div class="stat-info">
                        <h3>Con Consejero</h3>
                        <p class="stat-number">
                            <?php echo count(array_filter($instituciones, function($i) { return !empty($i['consejero']); })); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="🔍 Buscar instituciones..." class="search-input">
                </div>
                <div class="actions-buttons">
                    <select class="filter-select" id="filterNivel">
                        <option value="all">Todos los niveles</option>
                        <option value="Inicial">Inicial</option>
                        <option value="Primaria">Primaria</option>
                        <option value="Secundaria">Secundaria</option>
                    </select>
                    <a href="<?php echo BASE_URL; ?>admin/instituciones/crear" class="btn btn-primary">
                        <span>➕</span> Crear Nueva Institución
                    </a>
                </div>
            </div>
            
            <?php if(!empty($instituciones)): ?>
                <div class="avisos-grid" id="institucionesGrid">
                    <?php foreach($instituciones as $institucion): ?>
                        <div class="aviso-card-admin" 
                             data-status="<?php echo $institucion['activo'] ? 'active' : 'inactive'; ?>"
                             data-nivel="<?php echo htmlspecialchars($institucion['nivel']); ?>">
                            <div class="aviso-header-card">
                                <div class="aviso-badges">
                                    <span class="badge badge-info"><?php echo htmlspecialchars($institucion['nivel']); ?></span>
                                    <?php if($institucion['activo']): ?>
                                        <span class="badge badge-success">✓ Activa</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">✗ Inactiva</span>
                                    <?php endif; ?>
                                </div>
                                <div class="aviso-id">#<?php echo $institucion['id']; ?></div>
                            </div>

                            <div class="aviso-body-card">
                                <h3 class="aviso-title"><?php echo htmlspecialchars($institucion['nombre']); ?></h3>
                                
                                <div class="oficina-info-extra" style="margin-top: 12px;">
                                    <?php if($institucion['direccion']): ?>
                                        <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 4px;">
                                            <strong>📍</strong> <?php echo htmlspecialchars($institucion['direccion']); ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if($institucion['telefono']): ?>
                                        <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 4px;">
                                            <strong>📞</strong> <?php echo htmlspecialchars($institucion['telefono']); ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if($institucion['email']): ?>
                                        <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 8px;">
                                            <strong>📧</strong> <?php echo htmlspecialchars($institucion['email']); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($institucion['consejero'])): ?>
                                        <p style="font-size: 13px; color: var(--primary-color); font-weight: 600; padding: 8px; background: rgba(102, 126, 234, 0.1); border-radius: 6px;">
                                            👔 Consejero: <?php echo htmlspecialchars($institucion['consejero']['nombre']); ?>
                                        </p>
                                    <?php else: ?>
                                        <p style="font-size: 13px; color: var(--warning); font-weight: 600;">
                                            ⚠️ Sin consejero asignado
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="aviso-footer-card">
                                <div class="aviso-meta">
                                    <span class="meta-item">
                                        <span class="meta-icon">🎓</span>
                                        <?php echo htmlspecialchars($institucion['nivel']); ?>
                                    </span>
                                </div>
                                <div class="aviso-actions">
                                    <a href="<?php echo BASE_URL; ?>admin/instituciones/asignarConsejero/<?php echo $institucion['id']; ?>" 
                                       class="btn-icon btn-view" 
                                       title="Asignar Consejero">
                                        👔
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>admin/instituciones/editar/<?php echo $institucion['id']; ?>" 
                                       class="btn-icon btn-edit" 
                                       title="Editar">
                                        ✏️
                                    </a>
                                    <button onclick="confirmarEliminar(<?php echo $institucion['id']; ?>, '<?php echo htmlspecialchars($institucion['nombre'], ENT_QUOTES); ?>')" 
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
                    <div class="empty-icon">🏫</div>
                    <h3>No hay instituciones todavía</h3>
                    <p>Comienza agregando la primera institución</p>
                    <a href="<?php echo BASE_URL; ?>admin/instituciones/crear" class="btn btn-primary btn-lg">
                        <span>➕</span> Crear Primera Institución
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>js/admin.js"></script>
    <script>
        function confirmarEliminar(id, nombre) {
            if(confirm(`¿Estás seguro de eliminar la institución "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
                window.location.href = '<?php echo BASE_URL; ?>admin/instituciones/eliminar/' + id;
            }
        }

        // Filtro por nivel
        document.getElementById('filterNivel').addEventListener('change', function() {
            const nivel = this.value;
            const cards = document.querySelectorAll('[data-nivel]');
            
            cards.forEach(card => {
                if(nivel === 'all' || card.dataset.nivel === nivel) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>