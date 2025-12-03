<section class="page-header">
    <div class="container">
        <h1>Sobre Nosotros</h1>
        <p>Conoce al Consejo Escolar y sus representantes</p>
    </div>
</section>

<?php if(!empty($informacion)): ?>
    <section class="informacion-institucional">
        <div class="container">
            <div class="info-grid">
                <?php foreach($informacion as $seccion): ?>
                    <div class="info-block">
                        <div class="info-icon">
                            <?php 
                            // Iconos según la sección
                            $iconos = [
                                'mision' => '🎯',
                                'vision' => '👁️',
                                'funciones' => '⚙️',
                                'historia' => '📜',
                                'valores' => '💎'
                            ];
                            echo $iconos[$seccion['seccion']] ?? '📋';
                            ?>
                        </div>
                        <h2><?php echo htmlspecialchars($seccion['titulo']); ?></h2>
                        <div class="info-contenido">
                            <?php echo nl2br(htmlspecialchars($seccion['contenido'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
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
                                <img src="<?php echo BASE_URL . 'uploads/consejeros/' . htmlspecialchars($consejero['foto']); ?>" 
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
                                    <p class="contacto-item">
                                        <strong>📧 Email:</strong>
                                        <a href="mailto:<?php echo htmlspecialchars($consejero['email']); ?>">
                                            <?php echo htmlspecialchars($consejero['email']); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                                <?php if($consejero['telefono']): ?>
                                    <p class="contacto-item">
                                        <strong>📞 Teléfono:</strong> 
                                        <?php echo htmlspecialchars($consejero['telefono']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            
                            <?php if(!empty($consejero['instituciones'])): ?>
                                <div class="instituciones-asignadas">
                                    <h4>🏫 Instituciones a cargo:</h4>
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

<style>
/* Estilos para Información Institucional */
.informacion-institucional {
    padding: var(--spacing-3xl) 0;
    background: linear-gradient(135deg, var(--bg-tertiary) 0%, white 100%);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: var(--spacing-2xl);
    margin-top: var(--spacing-xl);
}

.info-block {
    background: white;
    padding: var(--spacing-2xl);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    transition: all var(--transition-base);
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.info-block::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
    transform: scaleX(0);
    transition: transform var(--transition-base);
}

.info-block:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.info-block:hover::before {
    transform: scaleX(1);
}

.info-icon {
    font-size: 3rem;
    margin-bottom: var(--spacing-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: var(--radius-lg);
    margin-left: auto;
    margin-right: auto;
}

.info-block h2 {
    font-size: 1.75rem;
    color: var(--text-primary);
    margin-bottom: var(--spacing-lg);
    font-weight: 800;
    text-align: center;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.info-contenido {
    color: var(--text-secondary);
    line-height: 1.8;
    font-size: 1.0625rem;
}

.info-contenido p {
    margin-bottom: var(--spacing-md);
}

/* Estilos mejorados para Consejeros */
.consejeros-seccion {
    padding: var(--spacing-3xl) 0;
    background: white;
}

.contacto {
    background: linear-gradient(135deg, var(--bg-tertiary) 0%, white 100%);
    padding: var(--spacing-lg);
    border-radius: var(--radius-md);
    margin: var(--spacing-lg) 0;
    border-left: 4px solid;
    border-image: var(--primary-gradient) 1;
}

.contacto-item {
    margin-bottom: var(--spacing-sm);
    font-size: 0.9375rem;
}

.contacto-item:last-child {
    margin-bottom: 0;
}

.contacto-item strong {
    color: var(--text-primary);
    font-weight: 700;
}

.contacto-item a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: all var(--transition-base);
}

.contacto-item a:hover {
    color: var(--secondary-color);
    text-decoration: underline;
}

.biografia {
    color: var(--text-secondary);
    line-height: 1.7;
    margin: var(--spacing-lg) 0;
    font-size: 0.9375rem;
}

.instituciones-asignadas {
    margin-top: var(--spacing-lg);
    padding: var(--spacing-lg);
    background: linear-gradient(135deg, rgba(79, 172, 254, 0.05) 0%, rgba(0, 242, 254, 0.05) 100%);
    border-radius: var(--radius-md);
    border: 2px solid rgba(79, 172, 254, 0.2);
}

.instituciones-asignadas h4 {
    color: var(--text-primary);
    margin-bottom: var(--spacing-md);
    font-weight: 800;
    font-size: 1rem;
}

.instituciones-asignadas ul {
    list-style: none;
    padding: 0;
}

.instituciones-asignadas li {
    padding: var(--spacing-sm) 0;
    padding-left: var(--spacing-lg);
    position: relative;
    color: var(--text-secondary);
    font-weight: 600;
}

.instituciones-asignadas li::before {
    content: '▸';
    position: absolute;
    left: 0;
    color: var(--primary-color);
    font-weight: 800;
}

/* Responsive */
@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .info-block {
        padding: var(--spacing-xl);
    }
    
    .info-icon {
        width: 60px;
        height: 60px;
        font-size: 2rem;
    }
}
</style>