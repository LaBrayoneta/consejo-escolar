<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/admin.css">
</head>
<body class="admin-page">
    <?php include 'partials/sidebar.php'; ?>
    
    <div class="admin-content">
        <header class="admin-header">
            <div class="header-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <h1>Panel de Administración</h1>
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
            <!-- Saludo personalizado -->
            <div class="welcome-banner">
                <div class="welcome-content">
                    <h2>👋 ¡Bienvenido de nuevo, <?php echo htmlspecialchars($user['nombre']); ?>!</h2>
                    <p>Aquí tienes un resumen de tu sistema</p>
                </div>
                <div class="welcome-date">
                    <div class="date-display">
                        <span class="date-icon">📅</span>
                        <span class="date-text"><?php echo date('l, d \d\e F \d\e Y'); ?></span>
                    </div>
                    <div class="time-display">
                        <span class="time-icon">🕐</span>
                        <span class="time-text" id="currentTime"></span>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Mejoradas -->
            <div class="stats-row">
                <div class="stat-card stat-primary">
                    <div class="stat-icon-wrapper">
                        <div class="stat-icon">📝</div>
                        <div class="stat-badge"><?php echo $stats['total_avisos']; ?></div>
                    </div>
                    <div class="stat-info">
                        <h3>Total Avisos</h3>
                        <p class="stat-number"><?php echo $stats['total_avisos']; ?></p>
                        <div class="stat-footer">
                            <a href="<?php echo BASE_URL; ?>admin/avisos">Ver todos →</a>
                        </div>
                    </div>
                </div>

                <div class="stat-card stat-success">
                    <div class="stat-icon-wrapper">
                        <div class="stat-icon">🏢</div>
                        <div class="stat-badge"><?php echo $stats['total_oficinas']; ?></div>
                    </div>
                    <div class="stat-info">
                        <h3>Total Oficinas</h3>
                        <p class="stat-number"><?php echo $stats['total_oficinas']; ?></p>
                        <div class="stat-footer">
                            <a href="<?php echo BASE_URL; ?>admin/oficinas">Ver todas →</a>
                        </div>
                    </div>
                </div>

                <div class="stat-card stat-warning">
                    <div class="stat-icon-wrapper">
                        <div class="stat-icon">👔</div>
                        <div class="stat-badge"><?php echo $stats['total_consejeros']; ?></div>
                    </div>
                    <div class="stat-info">
                        <h3>Total Consejeros</h3>
                        <p class="stat-number"><?php echo $stats['total_consejeros']; ?></p>
                        <div class="stat-footer">
                            <a href="<?php echo BASE_URL; ?>admin/consejeros">Ver todos →</a>
                        </div>
                    </div>
                </div>

                <div class="stat-card stat-info">
                    <div class="stat-icon-wrapper">
                        <div class="stat-icon">📋</div>
                        <div class="stat-badge"><?php echo $stats['total_info_institucional'] ?? 0; ?></div>
                    </div>
                    <div class="stat-info">
                        <h3>Info Institucional</h3>
                        <p class="stat-number"><?php echo $stats['total_info_institucional'] ?? 0; ?></p>
                        <div class="stat-footer">
                            <a href="<?php echo BASE_URL; ?>admin/informacion">Gestionar →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid de Acciones Rápidas y Actividad Reciente -->
            <div class="dashboard-grid">
                <!-- Acciones Rápidas Mejoradas -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2>⚡ Acciones Rápidas</h2>
                        <span class="section-subtitle">Gestiona tu contenido rápidamente</span>
                    </div>
                    
                    <div class="quick-actions-grid">
                        <a href="<?php echo BASE_URL; ?>admin/crear_aviso" class="action-card action-primary">
                            <div class="action-icon">✍️</div>
                            <div class="action-content">
                                <h3>Crear Aviso</h3>
                                <p>Publica un nuevo aviso o novedad</p>
                            </div>
                            <div class="action-arrow">→</div>
                        </a>

                        <a href="<?php echo BASE_URL; ?>admin/avisos" class="action-card action-success">
                            <div class="action-icon">📋</div>
                            <div class="action-content">
                                <h3>Gestionar Avisos</h3>
                                <p>Edita o elimina avisos existentes</p>
                            </div>
                            <div class="action-arrow">→</div>
                        </a>

                        <a href="<?php echo BASE_URL; ?>admin/oficinas" class="action-card action-warning">
                            <div class="action-icon">🏢</div>
                            <div class="action-content">
                                <h3>Administrar Oficinas</h3>
                                <p>Gestiona las oficinas del consejo</p>
                            </div>
                            <div class="action-arrow">→</div>
                        </a>

                        <a href="<?php echo BASE_URL; ?>admin/consejeros" class="action-card action-info">
                            <div class="action-icon">👥</div>
                            <div class="action-content">
                                <h3>Gestionar Consejeros</h3>
                                <p>Administra consejeros e instituciones</p>
                            </div>
                            <div class="action-arrow">→</div>
                        </a>

                        <a href="<?php echo BASE_URL; ?>admin/instituciones" class="action-card action-secondary">
                            <div class="action-icon">🏫</div>
                            <div class="action-content">
                                <h3>Instituciones</h3>
                                <p>Gestiona las instituciones educativas</p>
                            </div>
                            <div class="action-arrow">→</div>
                        </a>

                        <a href="<?php echo BASE_URL; ?>admin/informacion" class="action-card action-primary">
                            <div class="action-icon">📖</div>
                            <div class="action-content">
                                <h3>Info Institucional</h3>
                                <p>Gestiona la sección "Sobre Nosotros"</p>
                            </div>
                            <div class="action-arrow">→</div>
                        </a>

                        <a href="<?php echo BASE_URL; ?>" target="_blank" class="action-card action-neutral">
                            <div class="action-icon">🌐</div>
                            <div class="action-content">
                                <h3>Ver Sitio Público</h3>
                                <p>Visita el sitio web público</p>
                            </div>
                            <div class="action-arrow">↗</div>
                        </a>
                    </div>
                </div>

                <!-- Panel de Información del Sistema -->
                <div class="dashboard-section">
                    <div class="section-header">
                        <h2>📊 Resumen del Sistema</h2>
                        <span class="section-subtitle">Estado actual de tu plataforma</span>
                    </div>
                    
                    <div class="system-info-card">
                        <div class="info-item">
                            <div class="info-label">
                                <span class="info-icon">👤</span>
                                <span>Usuario Actual</span>
                            </div>
                            <div class="info-value"><?php echo htmlspecialchars($user['username']); ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <span class="info-icon">🔐</span>
                                <span>Rol</span>
                            </div>
                            <div class="info-value">
                                <span class="role-badge role-<?php echo $user['rol']; ?>">
                                    <?php echo ucfirst($user['rol']); ?>
                                </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <span class="info-icon">🕐</span>
                                <span>Última Sesión</span>
                            </div>
                            <div class="info-value">Hoy, <?php echo date('H:i'); ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <span class="info-icon">⚡</span>
                                <span>Estado del Sistema</span>
                            </div>
                            <div class="info-value">
                                <span class="status-badge status-active">
                                    <span class="status-dot"></span>
                                    Operativo
                                </span>
                            </div>
                        </div>

                        <div class="system-stats">
                            <div class="stat-mini">
                                <div class="stat-mini-label">Avisos</div>
                                <div class="stat-mini-value"><?php echo $stats['total_avisos']; ?></div>
                            </div>
                            <div class="stat-mini">
                                <div class="stat-mini-label">Oficinas</div>
                                <div class="stat-mini-value"><?php echo $stats['total_oficinas']; ?></div>
                            </div>
                            <div class="stat-mini">
                                <div class="stat-mini-label">Consejeros</div>
                                <div class="stat-mini-value"><?php echo $stats['total_consejeros']; ?></div>
                            </div>
                            <div class="stat-mini">
                                <div class="stat-mini-label">Info Inst.</div>
                                <div class="stat-mini-value"><?php echo $stats['total_info_institucional'] ?? 0; ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips y Consejos -->
                    <div class="tips-card">
                        <div class="tips-header">
                            <span class="tips-icon">💡</span>
                            <h3>Consejo del día</h3>
                        </div>
                        <p>Mantén tus avisos actualizados para que la comunidad esté siempre informada sobre las últimas novedades del Consejo Escolar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>js/admin.js"></script>
    <script>
        // Reloj en tiempo real
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('es-AR', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            });
            const timeElement = document.getElementById('currentTime');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }

        // Actualizar cada segundo
        updateTime();
        setInterval(updateTime, 1000);

        // Animación de entrada para las tarjetas
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stat-card, .action-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>

    <style>
        /* Estilos adicionales específicos del dashboard */
        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 32px;
            color: white;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .welcome-content {
            position: relative;
            z-index: 1;
        }

        .welcome-content h2 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .welcome-content p {
            opacity: 0.9;
            font-size: 16px;
        }

        .welcome-date {
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .date-display,
        .time-display {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
        }

        .date-icon,
        .time-icon {
            font-size: 20px;
        }

        .stat-card {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .stat-icon-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .stat-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger);
            color: white;
            font-size: 12px;
            font-weight: 800;
            padding: 4px 8px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(245, 101, 101, 0.4);
        }

        .stat-badge-pulse {
            position: absolute;
            top: -4px;
            right: -4px;
            color: #48bb78;
            font-size: 24px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
        }

        .stat-footer {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid var(--gray-200);
        }

        .stat-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .stat-footer a:hover {
            gap: 8px;
            color: var(--primary-dark);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 32px;
            margin-top: 32px;
        }

        .dashboard-section {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }

        .section-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid var(--gray-200);
        }

        .section-header h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .section-subtitle {
            color: var(--text-muted);
            font-size: 14px;
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .action-card {
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-gradient);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .action-card:hover {
            transform: translateX(8px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            border-color: var(--primary-color);
        }

        .action-card:hover::before {
            transform: scaleY(1);
        }

        .action-icon {
            font-size: 32px;
            flex-shrink: 0;
        }

        .action-content h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .action-content p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
        }

        .action-arrow {
            margin-left: auto;
            font-size: 24px;
            color: var(--primary-color);
            font-weight: 800;
        }

        .system-info-card {
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 14px;
        }

        .info-icon {
            font-size: 18px;
        }

        .info-value {
            font-weight: 700;
            color: var(--text-primary);
        }

        .role-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .role-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .role-editor {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .status-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 800;
        }

        .status-active {
            background: rgba(72, 187, 120, 0.15);
            color: #48bb78;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #48bb78;
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        .system-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid var(--gray-200);
        }

        .stat-mini {
            text-align: center;
            padding: 12px;
            background: white;
            border-radius: 8px;
        }

        .stat-mini-label {
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 4px;
            font-weight: 600;
        }

        .stat-mini-value {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary-color);
        }

        .tips-card {
            background: linear-gradient(135deg, #fff7e6 0%, #ffe7ba 100%);
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #ed8936;
        }

        .tips-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .tips-icon {
            font-size: 24px;
        }

        .tips-header h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-primary);
            margin: 0;
        }

        .tips-card p {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
        }

        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .welcome-banner {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .quick-actions-grid {
                grid-template-columns: 1fr;
            }

            .system-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</body>
</html>