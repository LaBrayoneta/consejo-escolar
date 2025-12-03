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
                <h1>Gestionar Consejeros</h1>
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
                    <div class="stat-icon">👔</div>
                    <div class="stat-info">
                        <h3>Total Consejeros</h3>
                        <p class="stat-number"><?php echo count($consejeros); ?></p>
                    </div>
                </div>
                <div class="stat-card stat-success">
                    <div class="stat-icon">✓</div>
                    <div class="stat-info">
                        <h3>Activos</h3>
                        <p class="stat-number">
                            <?php echo count(array_filter($consejeros, function($c) { return $c['activo']; })); ?>
                        </p>
                    </div>
                </div>
                <div class="stat-card stat-info">
                    <div class="stat-icon">🏫</div>
                    <div class="stat-info">
                        <h3>Instituciones Asignadas</h3>
                        <p class="stat-number">
                            <?php 
                            $totalInst = 0;
                            foreach($consejeros as $c) {
                                $totalInst += count($c['instituciones'] ?? []);
                            }
                            echo $totalInst;
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="🔍 Buscar consejeros..." class="search-input">
                </div>
                <div class="actions-buttons">
                    <a href="<?php echo BASE_URL; ?>admin/consejeros/crear" class="btn btn-primary">
                        <span>➕</span> Crear Nuevo Consejero
                    </a>
                </div>
            </div>
            
            <?php if(!empty($consejeros)): ?>
                <div class="avisos-grid" id="consejerosGrid">
                    <?php foreach($consejeros as $consejero): ?>
                        <div class="aviso-card-admin" data-status="<?php echo $consejero['activo'] ? 'active' : 'inactive'; ?>">
                            <div class="aviso-header-card">
                                <div class="aviso-badges">
                                    <?php if($consejero['activo']): ?>
                                        <span class="badge badge-success">✓ Activo</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">✗ Inactivo</span>
                                    <?php endif; ?>
                                </div>
                                <div class="aviso-id">#<?php echo $consejero['id']; ?></div>
                            </div>

                            <div class="aviso-body-card">
                                <h3 class="aviso-title"><?php echo htmlspecialchars($consejero['nombre']); ?></h3>
                                <p style="color: var(--primary-color); font-weight: 700; margin-bottom: 12px;">
                                    <?php echo htmlspecialchars($consejero['cargo']); ?>
                                </p>
                                
                                <?php if($consejero['biografia']): ?>
                                    <p class="aviso-excerpt">
                                        <?php echo substr(strip_tags($consejero['biografia']), 0, 120) . '...'; ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="oficina-info-extra" style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--gray-200);">
                                    <?php if($consejero['email']): ?>
                                        <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 4px;">
                                            <strong>📧</strong> <?php echo htmlspecialchars($consejero['email']); ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if($consejero['telefono']): ?>
                                        <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 8px;">
                                            <strong>📞</strong> <?php echo htmlspecialchars($consejero['telefono']); ?>
                                        </p>
                                    <?php endif; ?>
                                    <p style="font-size: 13px; color: var(--primary-color); font-weight: 600;">
                                        🏫 <?php echo count($consejero['instituciones'] ?? []); ?> institución(es) asignada(s)
                                    </p>
                                </div>
                            </div>

                            <div class="aviso-footer-card">
                                <div class="aviso-meta">
                                    <span class="meta-item">
                                        <span class="meta-icon">📊</span>
                                        Orden: <?php echo $consejero['orden']; ?>
                                    </span>
                                </div>
                                <div class="aviso-actions">
                                    <a href="<?php echo BASE_URL; ?>admin/consejeros/instituciones/<?php echo $consejero['id']; ?>" 
                                       class="btn-icon btn-view" 
                                       title="Gestionar Instituciones">
                                        🏫
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>admin/consejeros/editar/<?php echo $consejero['id']; ?>" 
                                       class="btn-icon btn-edit" 
                                       title="Editar">
                                        ✏️
                                    </a>
                                    <button onclick="confirmarEliminar(<?php echo $consejero['id']; ?>, '<?php echo htmlspecialchars($consejero['nombre'], ENT_QUOTES); ?>')" 
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
                    <div class="empty-icon">👔</div>
                    <h3>No hay consejeros todavía</h3>
                    <p>Comienza agregando el primer consejero</p>
                    <a href="<?php echo BASE_URL; ?>admin/consejeros/crear" class="btn btn-primary btn-lg">
                        <span>➕</span> Crear Primer Consejero
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>js/admin.js"></script>
    <script>
        function confirmarEliminar(id, nombre) {
            if(confirm(`¿Estás seguro de eliminar al consejero "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
                window.location.href = '<?php echo BASE_URL; ?>admin/consejeros/eliminar/' + id;
            }
        }
    </script>
</body>
</html>