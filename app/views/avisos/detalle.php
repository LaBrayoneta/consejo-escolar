<section class="page-header">
    <div class="container">
        <a href="<?php echo BASE_URL; ?>avisos" class="btn-back">← Volver a avisos</a>
    </div>
</section>

<section class="aviso-detalle">
    <div class="container">
        <article class="aviso-completo">
            <header class="aviso-header">
                <h1><?php echo htmlspecialchars($aviso['titulo']); ?></h1>
                <?php if($aviso['destacado']): ?>
                    <span class="badge-destacado">⭐ Destacado</span>
                <?php endif; ?>
                <div class="aviso-meta">
                    <span class="meta-fecha">
                        📅 Publicado el <?php echo date('d/m/Y H:i', strtotime($aviso['created_at'])); ?>
                    </span>
                    <?php if(isset($aviso['autor'])): ?>
                        <span class="meta-autor">
                            👤 Por <?php echo htmlspecialchars($aviso['autor']); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </header>
            
            <div class="aviso-contenido">
                <?php echo nl2br(htmlspecialchars($aviso['contenido'])); ?>
            </div>
            
            <footer class="aviso-footer">
                <a href="<?php echo BASE_URL; ?>avisos" class="btn btn-secondary">
                    ← Volver a todos los avisos
                </a>
            </footer>
        </article>
    </div>
</section>

<style>
.aviso-detalle {
    padding: var(--spacing-3xl) 0;
    background: white;
}

.aviso-completo {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    padding: var(--spacing-2xl);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
}

.aviso-header {
    border-bottom: 3px solid var(--border-color);
    padding-bottom: var(--spacing-xl);
    margin-bottom: var(--spacing-xl);
    position: relative;
}

.aviso-header::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 120px;
    height: 3px;
    background: var(--primary-gradient);
    border-radius: var(--radius-full);
}

.aviso-header h1 {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    color: var(--text-primary);
    margin-bottom: var(--spacing-md);
    font-weight: 900;
    line-height: 1.2;
}

.aviso-meta {
    display: flex;
    gap: var(--spacing-lg);
    flex-wrap: wrap;
    margin-top: var(--spacing-md);
}

.meta-fecha,
.meta-autor {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
    color: var(--text-muted);
    font-size: 0.95rem;
    font-weight: 600;
}

.aviso-contenido {
    font-size: 1.125rem;
    line-height: 1.8;
    color: var(--text-secondary);
    margin-bottom: var(--spacing-2xl);
}

.aviso-contenido p {
    margin-bottom: var(--spacing-lg);
}

.aviso-footer {
    border-top: 2px solid var(--border-color);
    padding-top: var(--spacing-xl);
    text-align: center;
}

@media (max-width: 768px) {
    .aviso-completo {
        padding: var(--spacing-lg);
    }
    
    .aviso-meta {
        flex-direction: column;
        gap: var(--spacing-sm);
    }
}
</style>