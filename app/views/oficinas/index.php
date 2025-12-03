<section class="page-header">
    <div class="container">
        <h1>Nuestras Oficinas</h1>
        <p>Conoce las diferentes áreas que conforman el Consejo Escolar</p>
    </div>
</section>

<section class="oficinas-seccion">
    <div class="container">
        <?php if(!empty($oficinas)): ?>
            <div class="oficinas-tabs">
                <!-- Tabs Navigation -->
                <div class="tabs-nav">
                    <?php foreach($oficinas as $index => $oficina): ?>
                        <button 
                            class="tab-btn <?php echo $index === 0 ? 'active' : ''; ?>" 
                            data-tab="oficina-<?php echo $oficina['id']; ?>"
                            role="tab"
                            aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                            aria-controls="oficina-<?php echo $oficina['id']; ?>"
                        >
                            <?php echo htmlspecialchars($oficina['nombre']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Tabs Content -->
                <div class="tabs-content">
                    <?php foreach($oficinas as $index => $oficina): ?>
                        <div 
                            id="oficina-<?php echo $oficina['id']; ?>" 
                            class="tab-pane <?php echo $index === 0 ? 'active' : ''; ?>"
                            role="tabpanel"
                        >
                            <div class="oficina-detalle">
                                <div class="oficina-header">
                                    <h2><?php echo htmlspecialchars($oficina['nombre']); ?></h2>
                                    <p class="oficina-descripcion">
                                        <?php echo nl2br(htmlspecialchars($oficina['descripcion'])); ?>
                                    </p>
                                </div>

                                <div class="oficina-info-grid">
                                    <div class="info-section">
                                        <h3>📋 Funciones</h3>
                                        <div class="funciones-contenido">
                                            <?php echo nl2br(htmlspecialchars($oficina['funciones'])); ?>
                                        </div>
                                    </div>

                                    <div class="info-section">
                                        <h3>📞 Información de Contacto</h3>
                                        <div class="contacto-info">
                                            <p>
                                                <strong>Email Principal:</strong><br>
                                                <a href="mailto:<?php echo htmlspecialchars($oficina['email_principal']); ?>">
                                                    <?php echo htmlspecialchars($oficina['email_principal']); ?>
                                                </a>
                                            </p>
                                            
                                            <?php if($oficina['email_secundario']): ?>
                                                <p>
                                                    <strong>Email Secundario:</strong><br>
                                                    <a href="mailto:<?php echo htmlspecialchars($oficina['email_secundario']); ?>">
                                                        <?php echo htmlspecialchars($oficina['email_secundario']); ?>
                                                    </a>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <?php if($oficina['telefono']): ?>
                                                <p>
                                                    <strong>Teléfono:</strong><br>
                                                    <?php echo htmlspecialchars($oficina['telefono']); ?>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <?php if($oficina['ubicacion']): ?>
                                                <p>
                                                    <strong>Ubicación:</strong><br>
                                                    <?php echo htmlspecialchars($oficina['ubicacion']); ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if(!empty($oficina['empleados'])): ?>
                                    <div class="empleados-seccion">
                                        <h3>👥 Personal</h3>
                                        <div class="empleados-lista">
                                            <?php foreach($oficina['empleados'] as $empleado): ?>
                                                <div class="empleado-card">
                                                    <h4><?php echo htmlspecialchars($empleado['nombre']); ?></h4>
                                                    <p class="cargo"><?php echo htmlspecialchars($empleado['cargo']); ?></p>
                                                    
                                                    <?php if($empleado['email']): ?>
                                                        <p class="empleado-email">
                                                            📧 <a href="mailto:<?php echo htmlspecialchars($empleado['email']); ?>">
                                                                <?php echo htmlspecialchars($empleado['email']); ?>
                                                            </a>
                                                        </p>
                                                    <?php endif; ?>
                                                    
                                                    <?php if($empleado['telefono']): ?>
                                                        <p class="empleado-telefono">
                                                            📞 <?php echo htmlspecialchars($empleado['telefono']); ?>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>No hay oficinas disponibles en este momento.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.oficinas-seccion {
    padding: var(--spacing-3xl) 0;
}

.oficina-detalle {
    padding: var(--spacing-xl) 0;
}

.oficina-header {
    text-align: center;
    margin-bottom: var(--spacing-2xl);
    padding-bottom: var(--spacing-xl);
    border-bottom: 3px solid var(--border-color);
    position: relative;
}

.oficina-header::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 50%;
    transform: translateX(-50%);
    width: 120px;
    height: 3px;
    background: var(--primary-gradient);
    border-radius: var(--radius-full);
}

.oficina-header h2 {
    font-size: clamp(1.75rem, 3vw, 2.25rem);
    color: var(--text-primary);
    margin-bottom: var(--spacing-md);
    font-weight: 900;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.oficina-descripcion {
    font-size: 1.125rem;
    color: var(--text-secondary);
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.7;
}

.oficina-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--spacing-2xl);
    margin-bottom: var(--spacing-2xl);
}

.info-section {
    background: linear-gradient(135deg, var(--bg-tertiary) 0%, white 100%);
    padding: var(--spacing-xl);
    border-radius: var(--radius-lg);
    border-left: 4px solid;
    border-image: var(--primary-gradient) 1;
    box-shadow: var(--shadow-sm);
}

.info-section h3 {
    font-size: 1.375rem;
    color: var(--text-primary);
    margin-bottom: var(--spacing-lg);
    font-weight: 800;
}

.funciones-contenido {
    color: var(--text-secondary);
    line-height: 1.8;
}

.contacto-info p {
    margin-bottom: var(--spacing-md);
    line-height: 1.6;
}

.contacto-info strong {
    color: var(--text-primary);
    display: block;
    margin-bottom: var(--spacing-xs);
    font-weight: 700;
}

.contacto-info a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: all var(--transition-base);
}

.contacto-info a:hover {
    color: var(--secondary-color);
    text-decoration: underline;
}

.empleados-seccion {
    margin-top: var(--spacing-2xl);
    padding-top: var(--spacing-2xl);
    border-top: 2px solid var(--border-color);
}

.empleados-seccion h3 {
    font-size: 1.5rem;
    color: var(--text-primary);
    margin-bottom: var(--spacing-xl);
    font-weight: 800;
    text-align: center;
}

.empleado-email,
.empleado-telefono {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-top: var(--spacing-xs);
}

.empleado-email a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
}

.empleado-email a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .oficina-info-grid {
        grid-template-columns: 1fr;
    }
    
    .oficina-header h2 {
        font-size: 1.75rem;
    }
}
</style>