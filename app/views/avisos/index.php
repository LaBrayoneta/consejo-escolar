<section class="page-header">
    <div class="container">
        <h1>Avisos y Novedades</h1>
        <p>Mantente informado sobre las últimas noticias y comunicados del Consejo Escolar</p>
    </div>
</section>

<section class="avisos-seccion">
    <div class="container">
        <?php if(!empty($avisos)): ?>
            <div class="avisos-grid">
                <?php foreach($avisos as $aviso): ?>
                    <article class="aviso-card <?php echo $aviso['destacado'] ? 'destacado' : ''; ?>">
                        <?php if($aviso['destacado']): ?>
                            <span class="badge-destacado">⭐ Destacado</span>
                        <?php endif; ?>
                        
                        <h3><?php echo htmlspecialchars($aviso['titulo']); ?></h3>
                        
                        <p class="aviso-fecha">
                            <?php echo date('d/m/Y', strtotime($aviso['created_at'])); ?>
                        </p>
                        
                        <p class="aviso-excerpt">
                            <?php echo substr(strip_tags($aviso['contenido']), 0, 200) . '...'; ?>
                        </p>
                        
                        <a href="<?php echo BASE_URL; ?>avisos/detalle/<?php echo $aviso['id']; ?>" class="btn">
                            Leer más →
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>No hay avisos disponibles en este momento.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
.avisos-seccion {
    padding: var(--spacing-3xl) 0;
}

.avisos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: var(--spacing-xl);
}

.aviso-card {
    background: white;
    padding: var(--spacing-xl);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    transition: all var(--transition-base);
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.aviso-card::before {
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

.aviso-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.aviso-card:hover::before {
    transform: scaleX(1);
}

.aviso-card.destacado {
    background: linear-gradient(135deg, rgba(245, 87, 108, 0.05) 0%, white 100%);
    border-left: 4px solid;
    border-image: var(--accent-gradient) 1;
}

.aviso-card h3 {
    font-size: 1.5rem;
    color: var(--text-primary);
    margin-bottom: var(--spacing-md);
    font-weight: 800;
    line-height: 1.3;
}

.aviso-fecha {
    color: var(--text-muted);
    font-size: 0.875rem;
    margin-bottom: var(--spacing-md);
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-weight: 600;
}

.aviso-excerpt {
    color: var(--text-secondary);
    line-height: 1.7;
    margin-bottom: var(--spacing-lg);
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: var(--spacing-sm) var(--spacing-lg);
    background: var(--primary-gradient);
    color: white;
    text-decoration: none;
    border-radius: var(--radius-md);
    font-weight: 700;
    transition: all var(--transition-base);
    box-shadow: var(--shadow-sm);
}

.btn:hover {
    transform: translateX(4px);
    box-shadow: var(--shadow-md);
}

@media (max-width: 768px) {
    .avisos-grid {
        grid-template-columns: 1fr;
    }
}
</style>