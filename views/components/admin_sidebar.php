?>

<aside class="admin-sidebar">
    <div class="sidebar-header">
        <h2>Panel Admin</h2>
        <p class="user-welcome">Hola, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Usuario'); ?></p>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="/index.php?page=admin" class="<?php echo ($_GET['page'] ?? '') === 'admin' ? 'active' : ''; ?>">
                    <span class="icon">📊</span>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/index.php?page=admin/avisos" class="<?php echo strpos($_GET['page'] ?? '', 'admin/avisos') !== false ? 'active' : ''; ?>">
                    <span class="icon">📢</span>
                    Avisos
                </a>
            </li>
            <li>
                <a href="/index.php?page=admin/oficinas" class="<?php echo strpos($_GET['page'] ?? '', 'admin/oficinas') !== false ? 'active' : ''; ?>">
                    <span class="icon">🏢</span>
                    Oficinas
                </a>
            </li>
            <li>
                <a href="/index.php">
                    <span class="icon">🌐</span>
                    Ver Sitio
                </a>
            </li>
            <li>
                <a href="/index.php?page=auth/logout">
                    <span class="icon">🚪</span>
                    Cerrar Sesión
                </a>
            </li>
        </ul>
    </nav>
</aside>