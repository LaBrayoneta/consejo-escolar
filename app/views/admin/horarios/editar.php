<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/admin.css">
</head>
<body class="admin-page">
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>
    
    <div class="admin-content">
        <header class="admin-header">
            <h1>Editar Horario</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="admin-container">
            <div class="form-card">
                <!-- Current info -->
                <div style="background: linear-gradient(135deg, var(--gray-50) 0%, white 100%); border: 2px solid var(--gray-200); padding: 20px; border-radius: 12px; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <span style="font-size: 24px;">⏰</span>
                        <h3 style="margin: 0; color: var(--text-primary); font-size: 18px;">
                            Editando: <?php echo htmlspecialchars($horario['titulo']); ?>
                        </h3>
                    </div>
                    <p style="margin: 0; color: var(--text-muted); font-size: 13px;">
                        <strong>ID:</strong> #<?php echo $horario['id']; ?> | 
                        <strong>Tipo:</strong> <?php echo ucfirst($horario['tipo']); ?> |
                        <strong>Estado:</strong> <?php echo $horario['activo'] ? '✓ Activo' : '✗ Inactivo'; ?>
                    </p>
                </div>

                <form method="POST" action="<?php echo BASE_URL; ?>admin/horarios/editar/<?php echo $horario['id']; ?>">
                    <?php echo CSRF::insertTokenField(); ?>
                    
                    <div class="form-group">
                        <label for="tipo">Tipo de Horario *</label>
                        <select id="tipo" name="tipo" required onchange="toggleFechas(this.value)">
                            <option value="">-- Seleccione un tipo --</option>
                            <?php foreach($tipos as $key => $label): ?>
                                <option value="<?php echo $key; ?>" <?php echo $horario['tipo'] === $key ? 'selected' : ''; ?>>
                                    <?php echo $label; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="titulo">Título *</label>
                        <input 
                            type="text" 
                            id="titulo" 
                            name="titulo" 
                            required 
                            maxlength="100"
                            value="<?php echo htmlspecialchars($horario['titulo']); ?>"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea 
                            id="descripcion" 
                            name="descripcion" 
                            rows="3"
                        ><?php echo htmlspecialchars($horario['descripcion'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="dias_semana">Días de la Semana *</label>
                        <input 
                            type="text" 
                            id="dias_semana" 
                            name="dias_semana" 
                            required 
                            maxlength="100"
                            value="<?php echo htmlspecialchars($horario['dias_semana']); ?>"
                        >
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                        <div class="form-group">
                            <label for="hora_inicio">Hora de Inicio *</label>
                            <input 
                                type="time" 
                                id="hora_inicio" 
                                name="hora_inicio" 
                                required
                                value="<?php echo $horario['hora_inicio']; ?>"
                            >
                        </div>

                        <div class="form-group">
                            <label for="hora_fin">Hora de Fin *</label>
                            <input 
                                type="time" 
                                id="hora_fin" 
                                name="hora_fin" 
                                required
                                value="<?php echo $horario['hora_fin']; ?>"
                            >
                        </div>
                    </div>

                    <!-- Fechas de vigencia -->
                    <div id="fechasContainer" style="<?php echo $horario['tipo'] === 'general' ? 'display: none;' : ''; ?>">
                        <div style="background: rgba(237, 137, 54, 0.1); border-left: 4px solid var(--warning); padding: 16px; border-radius: 8px; margin-bottom: 20px;">
                            <p style="margin: 0; color: var(--text-primary); font-weight: 600; font-size: 14px;">
                                ⚠️ Periodo de vigencia para este horario
                            </p>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de Inicio</label>
                                <input 
                                    type="date" 
                                    id="fecha_inicio" 
                                    name="fecha_inicio"
                                    value="<?php echo $horario['fecha_inicio'] ?? ''; ?>"
                                >
                            </div>

                            <div class="form-group">
                                <label for="fecha_fin">Fecha de Fin</label>
                                <input 
                                    type="date" 
                                    id="fecha_fin" 
                                    name="fecha_fin"
                                    value="<?php echo $horario['fecha_fin'] ?? ''; ?>"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea 
                            id="observaciones" 
                            name="observaciones" 
                            rows="3"
                        ><?php echo htmlspecialchars($horario['observaciones'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="orden">Orden de visualización</label>
                        <input 
                            type="number" 
                            id="orden" 
                            name="orden"
                            value="<?php echo $horario['orden']; ?>"
                            min="0"
                        >
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="activo" value="1" <?php echo $horario['activo'] ? 'checked' : ''; ?>>
                            <span>Horario activo</span>
                        </label>
                    </div>

                    <!-- Metadata -->
                    <div style="background: var(--gray-50); padding: 16px; border-radius: 8px; margin: 24px 0;">
                        <h4 style="margin: 0 0 12px 0; color: var(--text-secondary); font-size: 14px; font-weight: 700;">
                            📊 Metadatos
                        </h4>
                        <div style="display: grid; gap: 8px; font-size: 13px; color: var(--text-muted);">
                            <p style="margin: 0;">
                                <strong>Creado:</strong> 
                                <?php echo date('d/m/Y H:i:s', strtotime($horario['created_at'])); ?>
                            </p>
                            <p style="margin: 0;">
                                <strong>Última actualización:</strong> 
                                <?php echo date('d/m/Y H:i:s', strtotime($horario['updated_at'])); ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a href="<?php echo BASE_URL; ?>admin/horarios" class="btn btn-secondary">Cancelar</a>
                        <button 
                            type="button"
                            class="btn btn-danger"
                            onclick="confirmarEliminar(<?php echo $horario['id']; ?>, '<?php echo htmlspecialchars($horario['titulo'], ENT_QUOTES); ?>')"
                        >
                            Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleFechas(tipo) {
            const fechasContainer = document.getElementById('fechasContainer');
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            
            if (tipo === 'general') {
                fechasContainer.style.display = 'none';
                fechaInicio.removeAttribute('required');
                fechaFin.removeAttribute('required');
            } else {
                fechasContainer.style.display = 'block';
            }
        }

        document.querySelector('form').addEventListener('submit', function(e) {
            const horaInicio = document.getElementById('hora_inicio').value;
            const horaFin = document.getElementById('hora_fin').value;
            
            if (horaInicio && horaFin && horaFin <= horaInicio) {
                e.preventDefault();
                alert('⚠️ La hora de fin debe ser posterior a la hora de inicio');
                return false;
            }
            
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;
            
            if (fechaInicio && fechaFin && fechaFin < fechaInicio) {
                e.preventDefault();
                alert('⚠️ La fecha de fin debe ser posterior a la fecha de inicio');
                return false;
            }
        });

        function confirmarEliminar(id, titulo) {
            if(confirm(`¿Estás seguro de eliminar el horario "${titulo}"?\n\nEsta acción no se puede deshacer.`)) {
                window.location.href = '<?php echo BASE_URL; ?>admin/horarios/eliminar/' + id;
            }
        }
    </script>
</body>
</html>