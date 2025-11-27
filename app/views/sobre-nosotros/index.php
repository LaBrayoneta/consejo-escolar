<section class="page-header">
    <div class="container">
        <h1>Sobre Nosotros</h1>
        <p>Conoce al Consejo Escolar y sus representantes</p>
    </div>
</section>

<?php if(!empty($informacion)): ?>
    <section class="informacion-institucional">
        <div class="container">
            <?php foreach($informacion as $seccion): ?>
                <div class="info-block">
                    <h2><?php echo htmlspecialchars($seccion['titulo']); ?></h2>
                    <div class="info-contenido">
                        <?php echo nl2br(htmlspecialchars($seccion['contenido'])); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<section class="consejeros-seccion">
    <div class="container">
        <h2>Nuestros Consejeros</h2>
        
        <?php if(!empty($consejeros)): ?>
            <div class="consejeros-grid">
                <?php foreach($consejeros as $consejero): ?>
                    <div class="consejero-card">
                        <?php if($consejero['foto']): ?>
                            <div class="consejero-foto">
                                <img src="<?php echo BASE_URL . 'images/consejeros/' . $consejero['foto']; ?>" 
                                     alt="<?php echo htmlspecialchars($consejero['nombre']); ?>">
                            </div>
                        <?php endif; ?>
                        
                        <div class="consejero-info">
                            <h3><?php echo htmlspecialchars($consejero['nombre']); ?></h3>
                            <p class="cargo"><?php echo htmlspecialchars($consejero['cargo']); ?></p>
                            
                            <?php if($consejero['biografia']): ?>
                                <p class="biografia"><?php echo nl2br(htmlspecialchars($consejero['biografia'])); ?></p>
                            <?php endif; ?>
                            
                            <div class="contacto">
                                <?php if($consejero['email']): ?>
                                    <p><strong>Email:</strong> 
                                       <a href="mailto:<?php echo $consejero['email']; ?>">
                                           <?php echo $consejero['email']; ?>
                                       </a>
                                    </p>
                                <?php endif; ?>
                                <?php if($consejero['telefono']): ?>
                                    <p><strong>Teléfono:</strong> <?php echo $consejero['telefono']; ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <?php if(!empty($consejero['instituciones'])): ?>
                                <div class="instituciones-asignadas">
                                    <h4>Instituciones a cargo:</h4>
                                    <ul>
                                        <?php foreach($consejero['instituciones'] as $inst): ?>
                                            <li><?php echo htmlspecialchars($inst['nombre']); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>No hay información de consejeros disponible en este momento.</p>
            </div>
        <?php endif; ?>
    </div>
</section>