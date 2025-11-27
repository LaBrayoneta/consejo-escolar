<section class="page-header">
    <div class="container">
        <h1>Nuestras Oficinas</h1>
        <p>Conoce los servicios y personal de cada área del Consejo Escolar</p>
    </div>
</section>

<section class="oficinas-seccion">
    <div class="container">
        <?php if(!empty($oficinas)): ?>
            <div class="oficinas-tabs">
                <div class="tabs-nav">
                    <?php foreach($oficinas as $index => $oficina): ?>
                        <button class="tab-btn <?php echo $index === 0 ? 'active' : ''; ?>" 
                                data-tab="oficina-<?php echo $oficina['id']; ?>">
                            <?php echo htmlspecialchars($oficina['nombre']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="tabs-content">
                    <?php foreach($oficinas as $index => $oficina): ?>
                        <div class="tab-pane <?php echo $index === 0 ? 'active' : ''; ?>" 
                             id="oficina-<?php echo $oficina['id']; ?>">
                            <div class="oficina-info">
                                <h2><?php echo htmlspecialchars($oficina['nombre']); ?></h2>
                                
                                <div class="info-section">
                                    <h3>Descripción</h3>
                                    <p><?php echo nl2br(htmlspecialchars($oficina['descripcion'])); ?></p>
                                </div>

                                <div class="info-section">
                                    <h3>Funciones</h3>
                                    <p><?php echo nl2br(htmlspecialchars($oficina['funciones'])); ?></p>
                                </div>

                                <div class="info-section">
                                    <h3>Contacto</h3>
                                    <p><strong>Email principal:</strong> 
                                       <a href="mailto:<?php echo $oficina['email_principal']; ?>">
                                           <?php echo $oficina['email_principal']; ?>
                                       </a>
                                    </p>
                                    <?php if($oficina['email_secundario']): ?>
                                        <p><strong>Email secundario:</strong> 
                                           <a href="mailto:<?php echo $oficina['email_secundario']; ?>">
                                               <?php echo $oficina['email_secundario']; ?>
                                           </a>
                                        </p>
                                    <?php endif; ?>
                                    <?php if($oficina['telefono']): ?>
                                        <p><strong>Teléfono:</strong> <?php echo $oficina['telefono']; ?></p>
                                    <?php endif; ?>
                                    <?php if($oficina['ubicacion']): ?>
                                        <p><strong>Ubicación:</strong> <?php echo $oficina['ubicacion']; ?></p>
                                    <?php endif; ?>
                                </div>

                                <?php if(!empty($oficina['empleados'])): ?>
                                    <div class="info-section">
                                        <h3>Personal</h3>
                                        <div class="empleados-lista">
                                            <?php foreach($oficina['empleados'] as $empleado): ?>
                                                <div class="empleado-card">
                                                    <h4><?php echo htmlspecialchars($empleado['nombre']); ?></h4>
                                                    <p class="cargo"><?php echo htmlspecialchars($empleado['cargo']); ?></p>
                                                    <?php if($empleado['email']): ?>
                                                        <p><a href="mailto:<?php echo $empleado['email']; ?>">
                                                            <?php echo $empleado['email']; ?>
                                                        </a></p>
                                                    <?php endif; ?>
                                                    <?php if($empleado['telefono']): ?>
                                                        <p><?php echo $empleado['telefono']; ?></p>
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
                <p>No hay información de oficinas disponible en este momento.</p>
            </div>
        <?php endif; ?>
    </div>
</section>