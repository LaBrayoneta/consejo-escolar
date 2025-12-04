<section class="page-header">
    <div class="container">
        <h1>⏰ Horarios de Atención</h1>
        <p>Conoce nuestros horarios para visitarnos</p>
    </div>
</section>

<section class="horarios-seccion">
    <div class="container">
        
        <?php if($horarioActual): ?>
            <!-- Horario Actual Destacado -->
            <div class="horario-actual-card">
                <div class="horario-badge">
                    <span class="badge-icon">🕐</span>
                    <span class="badge-text">Horario Actual</span>
                </div>
                
                <div class="horario-content">
                    <h2><?php echo htmlspecialchars($horarioActual['titulo']); ?></h2>
                    
                    <?php if($horarioActual['descripcion']): ?>
                        <p class="horario-descripcion">
                            <?php echo nl2br(htmlspecialchars($horarioActual['descripcion'])); ?>
                        </p>
                    <?php endif; ?>
                    
                    <div class="horario-detalles">
                        <div class="detalle-item">
                            <span class="detalle-icon">📅</span>
                            <div>
                                <strong>Días:</strong>
                                <p><?php echo htmlspecialchars($horarioActual['dias']); ?></p>
                            </div>
                        </div>
                        
                        <div class="detalle-item">
                            <span class="detalle-icon">🕒</span>
                            <div>
                                <strong>Horario:</strong>
                                <p class="horario-horas"><?php echo $horarioActual['horario']; ?></p>
                            </div>
                        </div>
                        
                        <?php if($horarioActual['observaciones']): ?>
                            <div class="detalle-item detalle-full">
                                <span class="detalle-icon">ℹ️</span>
                                <div>
                                    <strong>Observaciones:</strong>
                                    <p><?php echo nl2br(htmlspecialchars($horarioActual['observaciones'])); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($horarioActual['periodo'] !== 'Todo el año'): ?>
                            <div class="detalle-item detalle-full">
                                <span class="detalle-icon">📆</span>
                                <div>
                                    <strong>Vigencia:</strong>
                                    <p><?php echo $horarioActual['periodo']; ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Todos los Horarios -->
        <?php if(!empty($todosHorarios)): ?>
            <div class="todos-horarios-section">
                <h2>📋 Todos Nuestros Horarios</h2>
                <p class="section-description">
                    Consulta todos los horarios disponibles según la temporada
                </p>
                
                <div class="horarios-grid">
                    <?php foreach($todosHorarios as $horario): ?>
                        <div class="horario-card <?php echo $horario['vigente'] ? 'horario-vigente' : 'horario-futuro'; ?>">
                            <div class="horario-card-header">
                                <h3><?php echo htmlspecialchars($horario['titulo']); ?></h3>
                                <?php if($horario['vigente']): ?>
                                    <span class="badge badge-vigente">✓ Vigente</span>
                                <?php else: ?>
                                    <span class="badge badge-futuro">⏳ Futuro</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="horario-card-body">
                                <?php if($horario['descripcion']): ?>
                                    <p class="horario-desc">
                                        <?php echo nl2br(htmlspecialchars($horario['descripcion'])); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="horario-info">
                                    <div class="info-row">
                                        <span class="info-label">📅 Días:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($horario['dias']); ?></span>
                                    </div>
                                    
                                    <div class="info-row">
                                        <span class="info-label">🕒 Horario:</span>
                                        <span class="info-value info-highlight"><?php echo $horario['horario']; ?></span>
                                    </div>
                                    
                                    <?php if($horario['periodo'] !== 'Todo el año'): ?>
                                        <div class="info-row">
                                            <span class="info-label">📆 Periodo:</span>
                                            <span class="info-value"><?php echo $horario['periodo']; ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if($horario['observaciones']): ?>
                                        <div class="info-row info-obs">
                                            <span class="info-label">ℹ️ Nota:</span>
                                            <span class="info-value"><?php echo nl2br(htmlspecialchars($horario['observaciones'])); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>No hay información de horarios disponible en este momento.</p>
            </div>
        <?php endif; ?>

        <!-- Información Adicional -->
        <div class="info-adicional">
            <div class="info-box">
                <h3>📍 Ubicación</h3>
                <p>Consejo Escolar de Bahía Blanca<br>
                   Dirección: [Completar dirección]<br>
                   Teléfono: [Completar teléfono]</p>
            </div>
            
            <div class="info-box">
                <h3>📞 Contacto</h3>
                <p>Para consultas sobre horarios especiales<br>
                   o atención fuera del horario regular,<br>
                   comuníquese telefónicamente.</p>
            </div>
            
            <div class="info-box">
                <h3>🎯 Turnos</h3>
                <p>Algunos trámites requieren turno previo.<br>
                   Consulte en nuestras oficinas<br>
                   para más información.</p>
            </div>
        </div>
    </div>
</section>

<style>
.horarios-seccion {
    padding: var(--spacing-3xl) 0;
    background: linear-gradient(135deg, var(--bg-tertiary) 0%, white 100%);
}

/* Horario Actual Destacado */
.horario-actual-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    margin-bottom: var(--spacing-3xl);
    border: 2px solid var(--primary-color);
    position: relative;
}

.horario-actual-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: var(--primary-gradient);
}

.horario-badge {
    background: var(--primary-gradient);
    color: white;
    padding: var(--spacing-lg) var(--spacing-xl);
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    font-weight: 800;
    font-size: 1.125rem;
}

.badge-icon {
    font-size: 1.5rem;
    animation: pulse-icon 2s ease-in-out infinite;
}

@keyframes pulse-icon {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

.horario-content {
    padding: var(--spacing-2xl);
}

.horario-content h2 {
    font-size: clamp(1.75rem, 3vw, 2.25rem);
    color: var(--text-primary);
    margin-bottom: var(--spacing-lg);
    font-weight: 900;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.horario-descripcion {
    color: var(--text-secondary);
    font-size: 1.125rem;
    line-height: 1.7;
    margin-bottom: var(--spacing-xl);
}

.horario-detalles {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--spacing-lg);
}

.detalle-item {
    background: linear-gradient(135deg, var(--bg-tertiary) 0%, white 100%);
    padding: var(--spacing-lg);
    border-radius: var(--radius-md);
    display: flex;
    gap: var(--spacing-md);
    align-items: flex-start;
    border-left: 4px solid;
    border-image: var(--primary-gradient) 1;
}

.detalle-item.detalle-full {
    grid-column: 1 / -1;
}

.detalle-icon {
    font-size: 1.5rem;
    flex-shrink: 0;
}

.detalle-item strong {
    display: block;
    color: var(--primary-color);
    font-weight: 800;
    margin-bottom: var(--spacing-xs);
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detalle-item p {
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.6;
}

.horario-horas {
    font-size: 1.5rem;
    font-weight: 900;
    color: var(--primary-color);
    font-family: 'Monaco', 'Courier New', monospace;
}

/* Todos los Horarios */
.todos-horarios-section {
    margin-top: var(--spacing-3xl);
}

.todos-horarios-section > h2 {
    text-align: center;
    font-size: clamp(1.75rem, 3vw, 2.25rem);
    margin-bottom: var(--spacing-md);
    font-weight: 900;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-description {
    text-align: center;
    color: var(--text-secondary);
    font-size: 1.125rem;
    margin-bottom: var(--spacing-2xl);
}

.horarios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: var(--spacing-xl);
}

.horario-card {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    transition: all var(--transition-base);
    border: 2px solid var(--border-color);
}

.horario-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.horario-vigente {
    border-color: var(--primary-color);
}

.horario-card-header {
    padding: var(--spacing-lg);
    background: linear-gradient(135deg, var(--bg-tertiary) 0%, white 100%);
    border-bottom: 2px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: var(--spacing-md);
}

.horario-card-header h3 {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--text-primary);
    margin: 0;
}

.badge {
    padding: var(--spacing-xs) var(--spacing-md);
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.badge-vigente {
    background: linear-gradient(135deg, rgba(72, 187, 120, 0.15) 0%, rgba(56, 178, 172, 0.15) 100%);
    color: var(--success);
    border: 2px solid rgba(72, 187, 120, 0.3);
}

.badge-futuro {
    background: linear-gradient(135deg, rgba(237, 137, 54, 0.15) 0%, rgba(255, 193, 7, 0.15) 100%);
    color: var(--warning);
    border: 2px solid rgba(237, 137, 54, 0.3);
}

.horario-card-body {
    padding: var(--spacing-lg);
}

.horario-desc {
    color: var(--text-secondary);
    font-size: 0.9375rem;
    line-height: 1.6;
    margin-bottom: var(--spacing-lg);
}

.horario-info {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

.info-row {
    display: flex;
    gap: var(--spacing-sm);
    align-items: flex-start;
}

.info-row.info-obs {
    flex-direction: column;
    background: var(--bg-tertiary);
    padding: var(--spacing-md);
    border-radius: var(--radius-sm);
}

.info-label {
    font-weight: 700;
    color: var(--text-primary);
    min-width: 80px;
    flex-shrink: 0;
}

.info-value {
    color: var(--text-secondary);
}

.info-highlight {
    font-size: 1.25rem;
    font-weight: 900;
    color: var(--primary-color);
    font-family: 'Monaco', 'Courier New', monospace;
}

/* Información Adicional */
.info-adicional {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--spacing-xl);
    margin-top: var(--spacing-3xl);
}

.info-box {
    background: white;
    padding: var(--spacing-xl);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    text-align: center;
    border-top: 4px solid;
    border-image: var(--primary-gradient) 1;
}

.info-box h3 {
    font-size: 1.375rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: var(--spacing-md);
}

.info-box p {
    color: var(--text-secondary);
    line-height: 1.7;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .horario-detalles {
        grid-template-columns: 1fr;
    }
    
    .horarios-grid {
        grid-template-columns: 1fr;
    }
    
    .horario-card-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .info-adicional {
        grid-template-columns: 1fr;
    }
}
</style>