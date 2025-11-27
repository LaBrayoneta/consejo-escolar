<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/admin.css">
</head>
<body class="admin-page">
    <?php include '../app/views/admin/partials/sidebar.php'; ?>
    
    <div class="admin-content">
        <header class="admin-header">
            <h1>Gestionar Avisos</h1>
            <div class="user-info">
                <span>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
                <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-secondary">Cerrar Sesión</a>
            </div>
        </header>
        
        <div class="admin-container">
            <div class="table-header">
                <h2>Lista de Avisos</h2>
                <a href="<?php echo BASE_URL; ?>admin/crear_aviso" class="btn btn-primary">
                    + Nuevo Aviso
                </a>
            </div>
            
            <?php if(!empty($avisos)): ?>
                <div class="table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Destacado</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($avisos as $aviso): ?>
                                <tr>
                                    <td><?php echo $aviso['id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($aviso['titulo']); ?></strong>
                                        <br>
                                        <small><?php echo substr(strip_tags($aviso['contenido']), 0, 100); ?>...</small>
                                    </td>
                                    <td>
                                        <?php if($aviso['destacado']): ?>
                                            <span class="badge badge-warning">Destacado</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Normal</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($aviso['activo']): ?>
                                            <span class="badge badge-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small><?php echo date('d/m/Y H:i', strtotime($aviso['created_at'])); ?></small>
                                    </td>
                                    <td class="table-actions">
                                        <a href="<?php echo BASE_URL; ?>avisos/detalle/<?php echo $aviso['id']; ?>" 
                                           class="btn-action btn-view" 
                                           title="Ver"
                                           target="_blank">
                                            👁️
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>admin/editar_aviso/<?php echo $aviso['id']; ?>" 
                                           class="btn-action btn-edit" 
                                           title="Editar">
                                            ✏️
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>admin/eliminar_aviso/<?php echo $aviso['id']; ?>" 
                                           class="btn-action btn-delete" 
                                           title="Eliminar"
                                           onclick="return confirmarEliminacion('¿Eliminar el aviso: <?php echo htmlspecialchars($aviso['titulo']); ?>?')">
                                            🗑️
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>No hay avisos registrados.</p>
                    <a href="<?php echo BASE_URL; ?>admin/crear_aviso" class="btn btn-primary">
                        Crear primer aviso
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>