<section class="hero">
    <div class="container">
        <h1>Bienvenidos al Consejo Escolar</h1>
        <p>Trabajamos por la educación de nuestro distrito</p>
    </div>
</section>

<?php if(!empty($avisosDestacados)): ?>
<section class="avisos-destacados">
    <div class="container">
        <h2>Avisos Destacados</h2>
        <div class="avisos-grid">
            <?php foreach($avisosDestacados as $aviso): ?>
                <article class="aviso-card destacado">
                    <h3><?php echo htmlspecialchars($aviso['titulo']); ?></h3>
                    <p class="aviso-fecha"><?php echo date('d/m/Y', strtotime($aviso['created_at'])); ?></p>
                    <p class="aviso-excerpt">
                        <?php echo substr(strip_tags($aviso['contenido']), 0, 150) . '...'; ?>
                    </p>
                    <a href="<?php echo BASE_URL; ?>avisos/detalle/<?php echo $aviso['id']; ?>" class="btn">Leer más</a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="ultimos-avisos">
    <div class="container">
        <h2>Últimas Novedades</h2>
        <div class="avisos-lista">
            <?php if(!empty($ultimosAvisos)): ?>
                <?php foreach($ultimosAvisos as $aviso): ?>
                    <article class="aviso-item">
                        <div class="aviso-meta">
                            <span class="fecha"><?php echo date('d/m/Y', strtotime($aviso['created_at'])); ?></span>
                        </div>
                        <h3><?php echo htmlspecialchars($aviso['titulo']); ?></h3>
                        <p><?php echo substr(strip_tags($aviso['contenido']), 0, 200) . '...'; ?></p>
                        <a href="<?php echo BASE_URL; ?>avisos/detalle/<?php echo $aviso['id']; ?>">Ver más →</a>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay avisos disponibles en este momento.</p>
            <?php endif; ?>
        </div>
        <div class="text-center">
            <a href="<?php echo BASE_URL; ?>avisos" class="btn btn-secondary">Ver todos los avisos</a>
        </div>
    </div>
</section>