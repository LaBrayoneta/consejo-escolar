<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Consejo Escolar</title>
    <link rel="stylesheet" href="/views/assets/css/style.css">
    <link rel="stylesheet" href="/views/assets/css/admin.css">
</head>
<body>
    <?php include BASE_PATH . '/views/components/admin_header.php'; ?>
    
    <div class="admin-layout">
        <?php include BASE_PATH . '/views/components/admin_sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="admin-header">
                <h1>Panel de Administración</h1>
                <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
            </div>
            
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">📢</div>
                    <div class="stat-info">
                        <h3><?php echo $totalAvisos; ?></h3>
                        <p>Avisos Totales</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">🏢</div>
                    <div class="stat-info">
                        <h3><?php echo $totalOficinas; ?></h3>
                        <p>Oficinas Registradas</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-info">
                        <h3>-</h3>
                        <p>Usuarios</p>
                    </div>
                </div>
            </div>
            
            <div class="quick-actions">
                <h2>Acciones Rápidas</h2>
                <div class="action-buttons">
                    <a href="/admin/avisos" class="action-btn">
                        <span>📝</span>
                        Gestionar Avisos
                    </a>
                    <a href="/admin/oficinas" class="action-btn">
                        <span>🏢</span>
                        Gestionar Oficinas
                    </a>
                    <a href="/" class="action-btn">
                        <span>🌐</span>
                        Ver Sitio Público
                    </a>
                </div>
            </div>
        </main>
    </div>
    
    <script src="/views/assets/js/admin.js"></script>
</body>
</html>