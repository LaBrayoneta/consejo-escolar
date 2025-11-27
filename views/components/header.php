<header class="site-header">
    <div class="header-container">
        <div class="logo">
            <a href="/index.php">
                <h1>Consejo Escolar</h1>
            </a>
        </div>
        
        <nav class="main-nav">
            <ul>
                <li><a href="/index.php">Inicio</a></li>
                <li><a href="/index.php?page=home/oficinas">Oficinas</a></li>
                <li><a href="/index.php?page=home/about">Sobre Nosotros</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/index.php?page=admin">Panel Admin</a></li>
                    <li><a href="/index.php?page=auth/logout">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="/index.php?page=auth/login">Ingresar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        
        <button class="mobile-menu-toggle" id="mobileMenuToggle">
            <span>☰</span>
        </button>
    </div>
</header>