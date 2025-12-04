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
            <h1>Crear Nuevo Horario</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="admin-container">
            <div class="form-card">
                <!-- Info helper -->
                <div style="background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.05) 100%); border-left: 4px solid #4facfe; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                    <h3 style="margin: 0 0 8px 0; color: #2563eb; font-size: 16px;">💡 Tipos de horarios</h3>
                    <ul style="margin: 0; padding-left: 20px; color: #4a5568; font-size: 14px; line-height: 1.8;">
                        <li><strong>General:</strong> Horario habitual del consejo durante todo el año</li>
                        <li><strong>Verano:</strong> Horario especial para temporada de verano</li>
                        <li><strong>Invierno:</strong> Horario especial para temporada de invierno</li>
                        <li><strong>Especial:</strong> Horario para fechas específicas (feriados, receso escolar, etc.)</li>
                    </ul>
                </div>

                <form method="POST" action="<?php echo BASE_URL; ?>admin/horarios/crear">
                    <?php echo CSRF::insertTokenField(); ?>
                    
                    <div class="form-group">
                        <label for="tipo">Tipo de Horario *</label>
                        <select id="tipo" name="tipo" required onchange="toggleFechas(this.value)">
                            <option value="">-- Seleccione un tipo --</option>
                            <?php foreach($tipos as $key => $label): ?>
                                <option value="<?php echo $key; ?>"><?php echo $label; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-hint">El horario general no requiere fechas de vigencia</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="titulo">Título *</label>
                        <input 
                            type="text" 
                            id="titulo" 
                            name="titulo" 
                            required 
                            maxlength="100"
                            placeholder="Ej: Horario de Atención al Público"
                            value="<?php echo isset($horario['titulo']) ? htmlspecialchars($horario['titulo']) : ''; ?>"
                        >
                        <small class="form-hint">Nombre descriptivo que se mostrará en el sitio público</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea 
                            id="descripcion" 
                            name="descripcion" 
                            rows="3"
                            placeholder="Breve descripción del horario (opcional)"
                        ><?php echo isset($horario['descripcion']) ? htmlspecialchars($horario['descripcion']) : ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="dias_semana">Días de la Semana *</label>
                        <input 
                            type="text" 
                            id="dias_semana" 
                            name="dias_semana" 
                            required 
                            maxlength="100"
                            placeholder="Ej: Lunes a Viernes"
                            value="<?php echo isset($horario['dias_semana']) ? htmlspecialchars($horario['dias_semana']) : ''; ?>"
                        >
                        <small class="form-hint">Especifica los días de atención</small>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                        <div class="form-group">
                            <label for="hora_inicio">Hora de Inicio *</label>
                            <input 
                                type="time" 
                                id="hora_inicio" 
                                name="hora_inicio" 
                                required
                                value="<?php echo isset($horario['hora_inicio']) ? $horario['hora_inicio'] : '08:00'; ?>"
                            >
                        </div>

                        <div class="form-group">
                            <label for="hora_fin">Hora de Fin *</label>
                            <input 
                                type="time" 
                                id="hora_fin" 
                                name="hora_fin" 
                                required
                                value="<?php echo isset($horario['hora_fin']) ? $horario['hora_fin'] : '16:00'; ?>"
                            >
                        </div>
                    </div>

                    <!-- Fechas de vigencia (solo para horarios no generales) -->
                    <div id="fechasContainer" style="display: none;">
                        <div style="background: rgba(237, 137, 54, 0.1); border-left: 4px solid var(--warning); padding: 16px; border-radius: 8px; margin-bottom: 20px;">
                            <p style="margin: 0; color: var(--text-primary); font-weight: 600; font-size: 14px;">
                                ⚠️ Define el periodo de vigencia para este horario especial
                            </p>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de Inicio</label>
                                <input 
                                    type="date" 
                                    id="fecha_inicio" 
                                    name="fecha_inicio"
                                    value="<?php echo isset($horario['fecha_inicio']) ? $horario['fecha_inicio'] : ''; ?>"
                                >
                                <small class="form-hint">Desde cuándo aplica este horario</small>
                            </div>

                            <div class="form-group">
                                <label for="fecha_fin">Fecha de Fin</label>
                                <input 
                                    type="date" 
                                    id="fecha_fin" 
                                    name="fecha_fin"
                                    value="<?php echo isset($horario['fecha_fin']) ? $horario['fecha_fin'] : ''; ?>"
                                >
                                <small class="form-hint">Hasta cuándo aplica este horario</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea 
                            id="observaciones" 
                            name="observaciones" 
                            rows="3"
                            placeholder="Información adicional, excepciones, aclaraciones..."
                        ><?php echo isset($horario['observaciones']) ? htmlspecialchars($horario['observaciones']) : ''; ?></textarea>
                        <small class="form-hint">Cualquier información adicional relevante</small>
                    </div>

                    <div class="form-group">
                        <label for="orden">Orden de visualización</label>
                        <input 
                            type="number" 
                            id="orden" 
                            name="orden"
                            value="<?php echo isset($horario['orden']) ? $horario['orden'] : '0'; ?>"
                            min="0"
                        >
                        <small class="form-hint">Orden en que aparecerá (menor número = primero)</small>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <label>
                            <input type="checkbox" name="activo" value="1" checked>
                            <span>Horario activo</span>
                        </label>
                        <small class="form-hint">Solo los horarios activos se muestran en el sitio público</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Crear Horario</button>
                        <a href="<?php echo BASE_URL; ?>admin/horarios" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Mostrar/ocultar campos de fechas según el tipo
        function toggleFechas(tipo) {
            const fechasContainer = document.getElementById('fechasContainer');
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            
            if (tipo === 'general') {
                fechasContainer.style.display = 'none';
                fechaInicio.removeAttribute('required');
                fechaFin.removeAttribute('required');
                fechaInicio.value = '';
                fechaFin.value = '';
            } else {
                fechasContainer.style.display = 'block';
                // No hacemos required porque puede ser opcional
            }
        }

        // Validar que hora_fin sea mayor que hora_inicio
        document.querySelector('form').addEventListener('submit', function(e) {
            const horaInicio = document.getElementById('hora_inicio').value;
            const horaFin = document.getElementById('hora_fin').value;
            
            if (horaInicio && horaFin && horaFin <= horaInicio) {
                e.preventDefault();
                alert('⚠️ La hora de fin debe ser posterior a la hora de inicio');
                return false;
            }
            
            // Validar fechas si existen
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;
            
            if (fechaInicio && fechaFin && fechaFin < fechaInicio) {
                e.preventDefault();
                alert('⚠️ La fecha de fin debe ser posterior a la fecha de inicio');
                return false;
            }
        });

        // Pre-llenar título según tipo seleccionado
        document.getElementById('tipo').addEventListener('change', function() {
            const tituloInput = document.getElementById('titulo');
            if (!tituloInput.value) {
                const titulos = {
                    'general': 'Horario de Atención General',
                    'verano': 'Horario de Verano',
                    'invierno': 'Horario de Invierno',
                    'especial': 'Horario Especial'
                };
                tituloInput.value = titulos[this.value] || '';
            }
        });
    </script>
</body>
</html>