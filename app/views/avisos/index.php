<section class="page-header">
    <div class="container">
        <h1>Avisos y Novedades</h1>
        <p>Mantente informado sobre las últimas noticias del Consejo Escolar</p>
    </div>
</section>

<section class="avisos-seccion">
    <div class="container">
        <?php if(!empty($avisos)): ?>
            <div class="avisos-lista">
                <?php foreach($avisos as $aviso): ?>
                    <article class="aviso-card <?php echo $aviso['destacado'] ? 'destacado' : ''; ?>">
                        <div class="aviso-header">
                            <h3><?php echo htmlspecialchars($aviso['titulo']); ?></h3>
                            <?php if($aviso['destacado']): ?>
                                <span class="badge-destacado">Destacado</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="aviso-meta">
                            <span class="fecha">
                                <?php echo date('d/m/Y H:i', strtotime($aviso['created_at'])); ?>
                            </span>
                            <?php if(isset($aviso['autor'])): ?>
                                <span class="autor">
                                    Por: <?php echo htmlspecialchars($aviso['autor']); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <p class="aviso-excerpt">
                            <?php echo substr(strip_tags($aviso['contenido']), 0, 200) . '...'; ?>
                        </p>
                        
                        <a href="<?php echo BASE_URL; ?>avisos/detalle/<?php echo $aviso['id']; ?>" class="btn">
                            Leer más
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