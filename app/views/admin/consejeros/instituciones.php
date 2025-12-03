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
            <h1>Gestionar Instituciones</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="admin-container">
            <div class="form-card">
                <div style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 20px; border-radius: 12px; margin-bottom: 24px;">
                    <h2 style="margin: 0 0 8px 0; font-size: 24px;">👔 <?php echo htmlspecialchars($consejero['nombre']); ?></h2>
                    <p style="margin: 0; opacity: 0.9;"><?php echo htmlspecialchars($consejero['cargo']); ?></p>
                </div>

                <h3 style="margin-bottom: 16px; color: var(--text-primary);">Instituciones Asignadas</h3>
                
                <?php if(!empty($consejero['instituciones'])): ?>
                    <div style="margin-bottom: 24px;">
                        <?php foreach($consejero['instituciones'] as $inst): ?>
                            <div style="background: var(--gray-100); padding: 16px; border-radius: 8px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <h4 style="margin: 0 0 4px 0; color: var(--text-primary);">
                                        🏫 <?php echo htmlspecialchars($inst['nombre']); ?>
                                    </h4>
                                    <p style="margin: 0; color: var(--text-secondary); font-size: 14px;">
                                        <?php echo htmlspecialchars($inst['nivel']); ?> - <?php echo htmlspecialchars($inst['direccion'] ?? 'Sin dirección'); ?>
                                    </p>
                                </div>
                                <form method="POST" action="<?php echo BASE_URL; ?>admin/consejeros/instituciones/<?php echo $consejero['id']; ?>" style="margin: 0;">
                                    <?php echo CSRF::insertTokenField(); ?>
                                    <input type="hidden" name="institucion_id" value="<?php echo $inst['id']; ?>">
                                    <input type="hidden" name="action" value="desasignar">
                                    <button type="submit" class="btn-icon btn-delete" title="Desasignar" onclick="return confirm('¿Desasignar esta institución?')">
                                        ❌
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 40px; background: var(--gray-100); border-radius: 12px; margin-bottom: 24px;">
                        <p style="font-size: 48px; margin-bottom: 16px;">📭</p>
                        <p style="color: var(--text-muted);">No hay instituciones asignadas todavía</p>
                    </div>
                <?php endif; ?>

                <h3 style="margin: 32px 0 16px 0; color: var(--text-primary);">Asignar Nueva Institución</h3>
                
                <form method="POST" action="<?php echo BASE_URL; ?>admin/consejeros/instituciones/<?php echo $consejero['id']; ?>">
                    <?php echo CSRF::insertTokenField(); ?>
                    <input type="hidden" name="action" value="asignar">
                    
                    <div class="form-group">
                        <label for="institucion_id">Seleccionar Institución</label>
                        <select id="institucion_id" name="institucion_id" required class="form-control">
                            <option value="">-- Seleccione una institución --</option>
                            <?php 
                            $institucionesAsignadas = array_column($consejero['instituciones'] ?? [], 'id');
                            foreach($instituciones as $inst): 
                                if(!in_array($inst['id'], $institucionesAsignadas)):
                            ?>
                                <option value="<?php echo $inst['id']; ?>">
                                    <?php echo htmlspecialchars($inst['nombre']); ?> (<?php echo htmlspecialchars($inst['nivel']); ?>)
                                </option>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Asignar Institución</button>
                        <a href="<?php echo BASE_URL; ?>admin/consejeros" class="btn btn-secondary">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>