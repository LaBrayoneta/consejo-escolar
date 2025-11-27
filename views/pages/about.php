<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - Consejo Escolar</title>
    <link rel="stylesheet" href="/views/assets/css/style.css">
</head>
<body>
    <?php include BASE_PATH . '/views/components/header.php'; ?>
    
    <main class="container">
        <section class="page-header">
            <h1>Sobre Nosotros</h1>
        </section>
        
        <!-- Funciones del Consejo Escolar -->
        <section class="funciones-section">
            <h2>Funciones del Consejo Escolar</h2>
            <div class="funciones-content">
                <p>El Consejo Escolar es el órgano responsable de la administración y gestión de los establecimientos educativos del distrito. Sus principales funciones incluyen:</p>
                
                <ul class="funciones-list">
                    <li>Administración y mantenimiento de los edificios escolares</li>
                    <li>Gestión de recursos materiales y financieros</li>
                    <li>Coordinación con autoridades educativas provinciales</li>
                    <li>Apoyo a proyectos educativos y actividades escolares</li>
                    <li>Atención a las necesidades de la comunidad educativa</li>
                </ul>
            </div>
        </section>
        
        <!-- Consejeros -->
        <section class="consejeros-section">
            <h2>Nuestros Consejeros</h2>
            
            <?php if (empty($consejeros)): ?>
                <p class="no-content">Información de consejeros no disponible.</p>
            <?php else: ?>
                <div class="consejeros-grid">
                    <?php foreach ($consejeros as $consejero): ?>
                        <div class="consejero-card">
                            <div class="consejero-info">
                                <h3><?php echo htmlspecialchars($consejero['nombre']); ?></h3>
                                <p class="cargo"><?php echo htmlspecialchars($consejero['cargo']); ?></p>
                                
                                <?php if (!empty($consejero['institucion'])): ?>
                                    <p class="institucion">
                                        <strong>Institución:</strong> 
                                        <?php echo htmlspecialchars($consejero['institucion']); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if (!empty($consejero['email'])): ?>
                                    <p class="email">
                                        <a href="mailto:<?php echo htmlspecialchars($consejero['email']); ?>">
                                            ✉️ <?php echo htmlspecialchars($consejero['email']); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
    
    <?php include BASE_PATH . '/views/components/footer.php'; ?>
</body>
</html>