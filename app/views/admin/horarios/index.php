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
                <h1>Gestionar Horarios de Atención</h1>
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
            <div class="info-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 24px; border-radius: 16px; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);">
                <h2 style="margin: 0 0 8px 0; font-size: 24px; font-weight: 800;">⏰ Sobre los Horarios</h2>
                <p style="margin: 0; opacity: 0.95; line-height: 1.6;">
                    Administra los horarios de atención del Consejo Escolar. Puedes configurar horarios regulares, de verano, invierno y especiales. 
                    El sistema mostrará automáticamente el horario vigente según las fechas configuradas.
                </p>
            </div>

            <!-- Stats -->
            <div class="stats-row">
                <div class="stat-card stat-primary">
                    <div class="stat-icon">⏰</div>
                    <div class="stat-info">
                        <h3>Total Horarios</h3>
                        <p class="stat-number"><?php echo count($horarios); ?></p>
                    </div>
                </div>
                <div class="stat-card stat-success">
                    <div class="stat-icon">✓</div>
                    <div class="stat-info">
                        <h3>Activos</h3>
                        <p class="stat-number">
                            <?php echo count(array_filter($horarios, function($h) { return $h['activo']; })); ?>
                        </p>
                    </div>
                </div>
                <div class="stat-card stat-info">
                    <div class="stat-icon">👁️</div>
                    <div class="stat-info">
                        <h3>Vista Pública</h3>
                        <p class="stat-number">
                            <a href="<?php echo BASE_URL; ?>horarios" target="_blank" style="color: var(--primary-color); text-decoration: none; font-size: 14px;">
                                Ver página →
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="actions-bar">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="🔍 Buscar horarios..." class="search-input">
                </div>
                <div class="actions-buttons">
                    <select class="filter-select" id="filterTipo">
                        <option value="all">Todos los tipos</option>
                        <?php foreach($tipos as $key => $label): ?>
                            <option value="<?php echo $key; ?>"><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <a href="<?php echo BASE_URL; ?>admin/horarios/crear" class="btn btn-primary">
                        <span>➕</span> Crear Nuevo Horario
                    </a>
                </div>
            </div>
            
            <?php if(!empty($horarios)): ?>
                <div class="avisos-grid" id="horariosGrid">
                    <?php foreach($horarios as $horario): ?>
                        <div class="aviso-card-admin" 
                             data-status="<?php echo $horario['activo'] ? 'active' : 'inactive'; ?>"
                             data-tipo="<?php echo htmlspecialchars($horario['tipo']); ?>">
                            <div class="aviso-header-card">
                                <div class="aviso-badges">
                                    <span class="badge badge-info" style="background: linear-gradient(135deg, rgba(79, 172, 254, 0.15) 0%, rgba(0, 242, 254, 0.15) 100%); color: #4facfe; border: 2px solid rgba(79, 172, 254, 0.3);">
                                        <?php 
                                        $iconos = ['general' => '🕐', 'verano' => '☀️', 'invierno' => '❄️', 'especial' => '⭐'];
                                        echo $iconos[$horario['tipo']] ?? '⏰';
                                        ?> 
                                        <?php echo ucfirst($horario['tipo']); ?>
                                    </span>
                                    <?php if($horario['activo']): ?>
                                        <span class="badge badge-success">✓ Activo</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">✗ Inactivo</span>
                                    <?php endif; ?>
                                </div>
                                <div class="aviso-id">#<?php echo $horario['id']; ?></div>
                            </div>

                            <div class="aviso-body-card">
                                <h3 class="aviso-title"><?php echo htmlspecialchars($horario['titulo']); ?></h3>
                                
                                <?php if($horario['descripcion']): ?>
                                    <p class="aviso-excerpt">
                                        <?php echo substr(strip_tags($horario['descripcion']), 0, 100) . '...'; ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="oficina-info-extra" style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--gray-200);">
                                    <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 6px;">
                                        <strong>📅</strong> <?php echo htmlspecialchars($horario['dias_semana']); ?>
                                    </p>
                                    <p style="font-size: 15px; color: var(--primary-color); font-weight: 800; margin-bottom: 8px; font-family: 'Monaco', monospace;">
                                        <strong>🕒</strong> <?php echo date('H:i', strtotime($horario['hora_inicio'])); ?> - <?php echo date('H:i', strtotime($horario['hora_fin'])); ?>
                                    </p>
                                    
                                    <?php if($horario['fecha_inicio'] && $horario['fecha_fin']): ?>
                                        <p style="font-size: 12px; color: var(--text-muted); margin-top: 6px;">
                                            <strong>📆 Vigencia:</strong> 
                                            <?php echo date('d/m/Y', strtotime($horario['fecha_inicio'])); ?> - 
                                            <?php echo date('d/m/Y', strtotime($horario['fecha_fin'])); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="aviso-footer-card">
                                <div class="aviso-meta">
                                    <span class="meta-item">
                                        <span class="meta-icon">📊</span>
                                        Orden: <?php echo $horario['orden']; ?>
                                    </span>
                                </div>
                                <div class="aviso-actions">
                                    <a href="<?php echo BASE_URL; ?>horarios" 
                                       class="btn-icon btn-view" 
                                       title="Ver en sitio público"
                                       target="_blank">
                                        👁️
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>admin/horarios/editar/<?php echo $horario['id']; ?>" 
                                       class="btn-icon btn-edit" 
                                       title="Editar">
                                        ✏️
                                    </a>
                                    <button onclick="confirmarEliminar(<?php echo $horario['id']; ?>, '<?php echo htmlspecialchars($horario['titulo'], ENT_QUOTES); ?>')" 
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
                    <div class="empty-icon">⏰</div>
                    <h3>No hay horarios todavía</h3>
                    <p>Comienza creando el primer horario de atención</p>
                    <a href="<?php echo BASE_URL; ?>admin/horarios/crear" class="btn btn-primary btn-lg">
                        <span>➕</span> Crear Primer Horario
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>js/admin.js"></script>
    <script>
        function confirmarEliminar(id, titulo) {
            if(confirm(`¿Estás seguro de eliminar el horario "${titulo}"?\n\nEsta acción no se puede deshacer.`)) {
                window.location.href = '<?php echo BASE_URL; ?>admin/horarios/eliminar/' + id;
            }
        }

        // Filtro por tipo
        document.getElementById('filterTipo').addEventListener('change', function() {
            const tipo = this.value;
            const cards = document.querySelectorAll('[data-tipo]');
            
            cards.forEach(card => {
                if(tipo === 'all' || card.dataset.tipo === tipo) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>