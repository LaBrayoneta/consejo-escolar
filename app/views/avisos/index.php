<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/admin.css">
</head>
<body class="admin-page">
    <?php include '../app/views/admin/partials/sidebar.php'; ?>
    
    <div class="admin-content">
        <header class="admin-header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <h1>Gestionar Avisos</h1>
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
                    <div class="stat-icon">📝</div>
                    <div class="stat-info">
                        <h3>Total Avisos</h3>
                        <p class="stat-number"><?php echo count($avisos); ?></p>
                    </div>
                </div>
                <div class="stat-card stat-warning">
                    <div class="stat-icon">⭐</div>
                    <div class="stat-info">
                        <h3>Destacados</h3>
                        <p class="stat-number">
                            <?php echo count(array_filter($avisos, function($a) { return $a['destacado']; })); ?>
                        </p>
                    </div>
                </div>
                <div class="stat-card stat-success">
                    <div class="stat-icon">✓</div>
                    <div class="stat-info">
                        <h3>Activos</h3>
                        <p class="stat-number">
                            <?php echo count(array_filter($avisos, function($a) { return $a['activo']; })); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="🔍 Buscar avisos..." class="search-input">
                </div>
                <div class="actions-buttons">
                    <select class="filter-select" id="filterStatus">
                        <option value="all">Todos los estados</option>
                        <option value="active">Solo activos</option>
                        <option value="inactive">Solo inactivos</option>
                        <option value="destacado">Solo destacados</option>
                    </select>
                    <a href="<?php echo BASE_URL; ?>admin/crear_aviso" class="btn btn-primary">
                        <span>➕</span> Crear Nuevo Aviso
                    </a>
                </div>
            </div>
            
            <?php if(!empty($avisos)): ?>
                <!-- Cards Grid View -->
                <div class="avisos-grid" id="avisosGrid">
                    <?php foreach($avisos as $aviso): ?>
                        <div class="aviso-card-admin" data-status="<?php echo $aviso['activo'] ? 'active' : 'inactive'; ?>" data-destacado="<?php echo $aviso['destacado'] ? '1' : '0'; ?>">
                            <div class="aviso-header-card">
                                <div class="aviso-badges">
                                    <?php if($aviso['destacado']): ?>
                                        <span class="badge badge-warning">⭐ Destacado</span>
                                    <?php endif; ?>
                                    <?php if($aviso['activo']): ?>
                                        <span class="badge badge-success">✓ Activo</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">✗ Inactivo</span>
                                    <?php endif; ?>
                                </div>
                                <div class="aviso-id">#<?php echo $aviso['id']; ?></div>
                            </div>

                            <div class="aviso-body-card">
                                <h3 class="aviso-title"><?php echo htmlspecialchars($aviso['titulo']); ?></h3>
                                <p class="aviso-excerpt">
                                    <?php echo substr(strip_tags($aviso['contenido']), 0, 120) . '...'; ?>
                                </p>
                            </div>

                            <div class="aviso-footer-card">
                                <div class="aviso-meta">
                                    <span class="meta-item">
                                        <span class="meta-icon">📅</span>
                                        <?php echo date('d/m/Y', strtotime($aviso['created_at'])); ?>
                                    </span>
                                    <span class="meta-item">
                                        <span class="meta-icon">👤</span>
                                        <?php echo htmlspecialchars($aviso['autor'] ?? 'N/A'); ?>
                                    </span>
                                </div>
                                <div class="aviso-actions">
                                    <a href="<?php echo BASE_URL; ?>avisos/detalle/<?php echo $aviso['id']; ?>" 
                                       class="btn-icon btn-view" 
                                       title="Ver"
                                       target="_blank">
                                        👁️
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>admin/editar_aviso/<?php echo $aviso['id']; ?>" 
                                       class="btn-icon btn-edit" 
                                       title="Editar">
                                        ✏️
                                    </a>
                                    <button onclick="confirmarEliminar(<?php echo $aviso['id']; ?>, '<?php echo htmlspecialchars($aviso['titulo']); ?>')" 
                                            class="btn-icon btn-delete" 
                                            title="Eliminar">
                                        🗑️
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Empty State para búsqueda -->
                <div class="empty-search" id="emptySearch" style="display: none;">
                    <div class="empty-icon">🔍</div>
                    <h3>No se encontraron resultados</h3>
                    <p>Intenta con otros términos de búsqueda</p>
                </div>
            <?php else: ?>
                <div class="empty-state-admin">
                    <div class="empty-icon">📭</div>
                    <h3>No hay avisos todavía</h3>
                    <p>Comienza creando tu primer aviso</p>
                    <a href="<?php echo BASE_URL; ?>admin/crear_aviso" class="btn btn-primary btn-lg">
                        <span>➕</span> Crear Primer Aviso
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>js/admin.js"></script>
    <script>
        function confirmarEliminar(id, titulo) {
            if(confirm(`¿Estás seguro de eliminar el aviso "${titulo}"?\n\nEsta acción no se puede deshacer.`)) {
                window.location.href = '<?php echo BASE_URL; ?>admin/eliminar_aviso/' + id;
            }
        }
    </script>
</body>
</html>