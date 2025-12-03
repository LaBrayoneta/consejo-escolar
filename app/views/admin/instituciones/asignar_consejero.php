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
            <h1>Asignar Consejero</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="admin-container">
            <div class="form-card">
                <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: 12px; margin-bottom: 24px;">
                    <h2 style="margin: 0 0 8px 0; font-size: 24px;">🏫 <?php echo htmlspecialchars($institucion['nombre']); ?></h2>
                    <p style="margin: 0; opacity: 0.9;">
                        <?php echo htmlspecialchars($institucion['nivel']); ?>
                        <?php if($institucion['direccion']): ?>
                            - <?php echo htmlspecialchars($institucion['direccion']); ?>
                        <?php endif; ?>
                    </p>
                </div>

                <?php if(!empty($institucion['consejero'])): ?>
                    <div style="background: rgba(72, 187, 120, 0.1); border-left: 4px solid var(--success); padding: 20px; border-radius: 8px; margin-bottom: 24px;">
                        <h3 style="margin: 0 0 8px 0; color: var(--success); font-size: 16px;">✓ Consejero Actual</h3>
                        <p style="margin: 0; font-size: 18px; font-weight: 700; color: var(--text-primary);">
                            👔 <?php echo htmlspecialchars($institucion['consejero']['nombre']); ?>
                        </p>
                        <p style="margin: 4px 0 0 0; color: var(--text-secondary);">
                            <?php echo htmlspecialchars($institucion['consejero']['cargo']); ?>
                        </p>
                    </div>
                <?php else: ?>
                    <div style="background: rgba(237, 137, 54, 0.1); border-left: 4px solid var(--warning); padding: 20px; border-radius: 8px; margin-bottom: 24px;">
                        <h3 style="margin: 0 0 8px 0; color: var(--warning); font-size: 16px;">⚠️ Sin Consejero Asignado</h3>
                        <p style="margin: 0; color: var(--text-secondary);">
                            Esta institución no tiene un consejero asignado actualmente
                        </p>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo BASE_URL; ?>admin/instituciones/asignarConsejero/<?php echo $institucion['id']; ?>">
                    <?php echo CSRF::insertTokenField(); ?>
                    
                    <div class="form-group">
                        <label for="consejero_id">Seleccionar Consejero</label>
                        <select id="consejero_id" name="consejero_id" class="form-control">
                            <option value="">-- Sin consejero asignado --</option>
                            <?php foreach($consejeros as $consejero): ?>
                                <option 
                                    value="<?php echo $consejero['id']; ?>"
                                    <?php echo (!empty($institucion['consejero']) && $institucion['consejero']['id'] == $consejero['id']) ? 'selected' : ''; ?>
                                >
                                    <?php echo htmlspecialchars($consejero['nombre']); ?> 
                                    (<?php echo htmlspecialchars($consejero['cargo']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-hint">Selecciona un consejero para asignar a esta institución, o deja vacío para desasignar</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Guardar Asignación</button>
                        <a href="<?php echo BASE_URL; ?>admin/instituciones" class="btn btn-secondary">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>