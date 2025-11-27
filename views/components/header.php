<header class="site-header">
    <div class="header-container">
        <div class="logo">
            <a href="/">
                <h1>Consejo Escolar</h1>
            </a>
        </div>
        
        <nav class="main-nav">
            <ul>
                <li><a href="/">Inicio</a></li>
                <li><a href="/home/oficinas">Oficinas</a></li>
                <li><a href="/home/about">Sobre Nosotros</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/admin">Panel Admin</a></li>
                    <li><a href="/auth/logout">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="/auth/login">Ingresar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        
        <button class="mobile-menu-toggle" id="mobileMenuToggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>