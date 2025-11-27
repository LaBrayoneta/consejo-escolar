}<aside class="admin-sidebar">
    <div class="sidebar-header">
        <h2>Panel Admin</h2>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="/admin" class="<?php echo $_SERVER['REQUEST_URI'] === '/admin' ? 'active' : ''; ?>">
                    <span class="icon">📊</span>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/admin/avisos" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/avisos') !== false ? 'active' : ''; ?>">
                    <span class="icon">📢</span>
                    Avisos
                </a>
            </li>
            <li>
                <a href="/admin/oficinas" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/oficinas') !== false ? 'active' : ''; ?>">
                    <span class="icon">🏢</span>
                    Oficinas
                </a>
            </li>
            <li>
                <a href="/">
                    <span class="icon">🌐</span>
                    Ver Sitio
                </a>
            </li>
            <li>
                <a href="/auth/logout">
                    <span class="icon">🚪</span>
                    Cerrar Sesión
                </a>
            </li>
        </ul>
    </nav>
</aside>