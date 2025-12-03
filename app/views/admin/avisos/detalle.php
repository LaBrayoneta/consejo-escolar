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
                    <span class="badge-destacado">Destacado</span>
                <?php endif; ?>
                <div class="aviso-meta">
                    <span>Publicado el <?php echo date('d/m/Y H:i', strtotime($aviso['created_at'])); ?></span>
                </div>
            </header>
            <div class="aviso-contenido">
                <?php echo nl2br(htmlspecialchars($aviso['contenido'])); ?>
            </div>
        </article>
    </div>
</section>