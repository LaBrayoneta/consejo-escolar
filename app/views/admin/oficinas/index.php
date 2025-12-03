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
                <h1>Gestionar Oficinas</h1>
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
                    <div class="stat-icon">🏢</div>
                    <div class="stat-info">
                        <h3>Total Oficinas</h3>
                        <p class="stat-number"><?php echo count($oficinas); ?></p>
                    </div>
                </div>
                <div class="stat-card stat-success">
                    <div class="stat-icon">✓</div>
                    <div class="stat-info">
                        <h3>Activas</h3>
                        <p class="stat-number">
                            <?php echo count(array_filter($oficinas, function($o) { return $o['activo']; })); ?>
                        </p>
                    </div>
                </div>
                <div class="stat-card stat-info">
                    <div class="stat-icon">👥</div>
                    <div class="stat-info">
                        <h3>Total Empleados</h3>
                        <p class="stat-number">
                            <?php 
                            $totalEmpleados = 0;
                            foreach($oficinas as $o) {
                                $totalEmpleados += count($o['empleados'] ?? []);
                            }
                            echo $totalEmpleados;
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="🔍 Buscar oficinas..." class="search-input">
                </div>
                <div class="actions-buttons">
                    <a href="<?php echo BASE_URL; ?>admin/oficinas/crear" class="btn btn-primary">
                        <span>➕</span> Crear Nueva Oficina
                    </a>
                </div>
            </div>
            
            <?php if(!empty($oficinas)): ?>
                <div class="avisos-grid" id="oficinasGrid">
                    <?php foreach($oficinas as $oficina): ?>
                        <div class="aviso-card-admin" data-status="<?php echo $oficina['activo'] ? 'active' : 'inactive'; ?>">
                            <div class="aviso-header-card">
                                <div class="aviso-badges">
                                    <?php if($oficina['activo']): ?>
                                        <span class="badge badge-success">✓ Activa</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">✗ Inactiva</span>
                                    <?php endif; ?>
                                </div>
                                <div class="aviso-id">#<?php echo $oficina['id']; ?></div>
                            </div>

                            <div class="aviso-body-card">
                                <h3 class="aviso-title"><?php echo htmlspecialchars($oficina['nombre']); ?></h3>
                                <p class="aviso-excerpt">
                                    <?php echo substr(strip_tags($oficina['descripcion']), 0, 120) . '...'; ?>
                                </p>
                                
                                <div class="oficina-info-extra" style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--gray-200);">
                                    <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 4px;">
                                        <strong>📧</strong> <?php echo htmlspecialchars($oficina['email_principal']); ?>
                                    </p>
                                    <?php if($oficina['telefono']): ?>
                                        <p style="font-size: 13px; color: var(--text-secondary);">
                                            <strong>📞</strong> <?php echo htmlspecialchars($oficina['telefono']); ?>
                                        </p>
                                    <?php endif; ?>
                                    <p style="font-size: 13px; color: var(--primary-color); font-weight: 600; margin-top: 8px;">
                                        👥 <?php echo count($oficina['empleados'] ?? []); ?> empleado(s)
                                    </p>
                                </div>
                            </div>

                            <div class="aviso-footer-card">
                                <div class="aviso-meta">
                                    <span class="meta-item">
                                        <span class="meta-icon">📊</span>
                                        Orden: <?php echo $oficina['orden']; ?>
                                    </span>
                                </div>
                                <div class="aviso-actions">
                                    <a href="<?php echo BASE_URL; ?>admin/oficinas/editar/<?php echo $oficina['id']; ?>" 
                                       class="btn-icon btn-edit" 
                                       title="Editar">
                                        ✏️
                                    </a>
                                    <button onclick="confirmarEliminar(<?php echo $oficina['id']; ?>, '<?php echo htmlspecialchars($oficina['nombre'], ENT_QUOTES); ?>')" 
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
                    <div class="empty-icon">🏢</div>
                    <h3>No hay oficinas todavía</h3>
                    <p>Comienza creando tu primera oficina</p>
                    <a href="<?php echo BASE_URL; ?>admin/oficinas/crear" class="btn btn-primary btn-lg">
                        <span>➕</span> Crear Primera Oficina
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>js/admin.js"></script>
    <script>
        function confirmarEliminar(id, nombre) {
            if(confirm(`¿Estás seguro de eliminar la oficina "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
                window.location.href = '<?php echo BASE_URL; ?>admin/oficinas/eliminar/' + id;
            }
        }
    </script>
</body>
</html>