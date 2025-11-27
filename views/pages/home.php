<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consejo Escolar - Inicio</title>
    <link rel="stylesheet" href="/views/assets/css/style.css">
</head>
<body>
    <?php include BASE_PATH . '/views/components/header.php'; ?>
    
    <main class="container">
        <!-- Sección de Bienvenida -->
        <section class="hero">
            <h1>Bienvenidos al Consejo Escolar</h1>
            <p>Información, servicios y novedades para la comunidad educativa</p>
        </section>
        
        <!-- Sección de Avisos -->
        <section class="avisos-section">
            <h2>Avisos y Novedades</h2>
            
            <?php if (empty($avisos)): ?>
                <p class="no-content">No hay avisos publicados en este momento.</p>
            <?php else: ?>
                <div class="avisos-grid">
                    <?php foreach ($avisos as $aviso): ?>
                        <article class="aviso-card">
                            <div class="aviso-date">
                                <?php echo date('d/m/Y', strtotime($aviso['fecha_publicacion'])); ?>
                            </div>
                            <h3><?php echo htmlspecialchars($aviso['titulo']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars(substr($aviso['contenido'], 0, 200))); ?>...</p>
                            <a href="#" class="btn-leer-mas">Leer más</a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        
        <!-- Sección de Acceso Rápido -->
        <section class="quick-access">
            <h2>Acceso Rápido</h2>
            <div class="cards-grid">
                <a href="/home/oficinas" class="access-card">
                    <div class="card-icon">📋</div>
                    <h3>Oficinas</h3>
                    <p>Información de contacto y servicios</p>
                </a>
                
                <a href="/home/about" class="access-card">
                    <div class="card-icon">👥</div>
                    <h3>Sobre Nosotros</h3>
                    <p>Consejeros y funciones</p>
                </a>
                
                <a href="#contacto" class="access-card">
                    <div class="card-icon">✉️</div>
                    <h3>Contacto</h3>
                    <p>Comunicate con nosotros</p>
                </a>
            </div>
        </section>
    </main>
    
    <?php include BASE_PATH . '/views/components/footer.php'; ?>
    
    <script src="/views/assets/js/main.js"></script>
</body>
</html>