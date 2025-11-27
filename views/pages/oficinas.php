<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficinas - Consejo Escolar</title>
    <link rel="stylesheet" href="/views/assets/css/style.css">
</head>
<body>
    <?php include BASE_PATH . '/views/components/header.php'; ?>
    
    <main class="container">
        <section class="page-header">
            <h1>Nuestras Oficinas</h1>
            <p>Información de contacto y servicios de cada oficina del Consejo Escolar</p>
        </section>
        
        <section class="oficinas-tabs">
            <?php if (empty($oficinas)): ?>
                <p class="no-content">No hay oficinas registradas.</p>
            <?php else: ?>
                <div class="tabs-navigation">
                    <?php foreach ($oficinas as $index => $oficina): ?>
                        <button class="tab-btn <?php echo $index === 0 ? 'active' : ''; ?>" 
                                data-tab="oficina-<?php echo $oficina['id']; ?>">
                            <?php echo htmlspecialchars($oficina['nombre']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
                
                <div class="tabs-content">
                    <?php foreach ($oficinas as $index => $oficina): ?>
                        <div class="tab-panel <?php echo $index === 0 ? 'active' : ''; ?>" 
                             id="oficina-<?php echo $oficina['id']; ?>">
                            <div class="oficina-card">
                                <h2><?php echo htmlspecialchars($oficina['nombre']); ?></h2>
                                
                                <div class="oficina-description">
                                    <h3>¿Qué hacemos?</h3>
                                    <p><?php echo nl2br(htmlspecialchars($oficina['descripcion'])); ?></p>
                                </div>
                                
                                <div class="oficina-contact">
                                    <h3>Contacto</h3>
                                    <div class="contact-info">
                                        <?php if (!empty($oficina['email'])): ?>
                                            <div class="contact-item">
                                                <span class="icon">✉️</span>
                                                <strong>Email:</strong>
                                                <a href="mailto:<?php echo htmlspecialchars($oficina['email']); ?>">
                                                    <?php echo htmlspecialchars($oficina['email']); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($oficina['telefono'])): ?>
                                            <div class="contact-item">
                                                <span class="icon">📞</span>
                                                <strong>Teléfono:</strong>
                                                <span><?php echo htmlspecialchars($oficina['telefono']); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
    
    <?php include BASE_PATH . '/views/components/footer.php'; ?>
    
    <script src="/views/assets/js/tabs.js"></script>
</body>
</html>