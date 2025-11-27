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
            <h1>Panel de Administración</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="dashboard">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Avisos</h3>
                    <p class="stat-number"><?php echo $stats['total_avisos']; ?></p>
                    <a href="<?php echo BASE_URL; ?>admin/avisos">Ver avisos →</a>
                </div>
                
                <div class="stat-card">
                    <h3>Total Oficinas</h3>
                    <p class="stat-number"><?php echo $stats['total_oficinas']; ?></p>
                    <a href="<?php echo BASE_URL; ?>admin/oficinas">Ver oficinas →</a>
                </div>
                
                <div class="stat-card">
                    <h3>Total Consejeros</h3>
                    <p class="stat-number"><?php echo $stats['total_consejeros']; ?></p>
                    <a href="<?php echo BASE_URL; ?>admin/consejeros">Ver consejeros →</a>
                </div>
            </div>
            
            <div class="quick-actions">
                <h2>Acciones Rápidas</h2>
                <div class="actions-grid">
                    <a href="<?php echo BASE_URL; ?>admin/crear_aviso" class="action-card">
                        <h3>Crear Aviso</h3>
                        <p>Publica un nuevo aviso o novedad</p>
                    </a>
                    <a href="<?php echo BASE_URL; ?>admin/avisos" class="action-card">
                        <h3>Gestionar Avisos</h3>
                        <p>Edita o elimina avisos existentes</p>
                    </a>
                    <a href="<?php echo BASE_URL; ?>" class="action-card">
                        <h3>Ver Sitio</h3>
                        <p>Visita el sitio público</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>