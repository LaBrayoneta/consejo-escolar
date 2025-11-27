<section class="page-header">
    <div class="container">
        <h1>Avisos y Novedades</h1>
        <p>Manténgase informado sobre las últimas novedades del Consejo Escolar</p>
    </div>
</section>

<section class="avisos-seccion">
    <div class="container">
        <div class="avisos-lista">
            <?php if(!empty($avisos)): ?>
                <?php foreach($avisos as $aviso): ?>
                    <article class="aviso-card">
                        <div class="aviso-header">
                            <h2><?php echo htmlspecialchars($aviso['titulo']); ?></h2>
                            <?php if($aviso['destacado']): ?>
                                <span class="badge-destacado">Destacado</span>
                            <?php endif; ?>
                        </div>
                        <div class="aviso-meta">
                            <span class="fecha">
                                <strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($aviso['created_at'])); ?>
                            </span>
                            <span class="autor">
                                <strong>Por:</strong> <?php echo htmlspecialchars($aviso['autor']); ?>
                            </span>
                        </div>
                        <div class="aviso-contenido">
                            <?php echo substr(strip_tags($aviso['contenido']), 0, 300) . '...'; ?>
                        </div>
                        <a href="<?php echo BASE_URL; ?>avisos/detalle/<?php echo $aviso['id']; ?>" class="btn btn-primary">Leer completo</a>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>No hay avisos publicados en este momento.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
