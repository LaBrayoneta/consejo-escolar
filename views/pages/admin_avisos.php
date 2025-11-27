<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Avisos - Admin</title>
    <link rel="stylesheet" href="/views/assets/css/style.css">
    <link rel="stylesheet" href="/views/assets/css/admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php include BASE_PATH . '/views/components/admin_sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="admin-header">
                <h1>Gestión de Avisos</h1>
            </div>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <div class="admin-form">
                <h2>Crear Nuevo Aviso</h2>
                <form method="POST" action="/index.php?page=admin/avisos">
                    <input type="hidden" name="action" value="create">
                    
                    <div class="form-group">
                        <label for="titulo">Título *</label>
                        <input type="text" id="titulo" name="titulo" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contenido">Contenido *</label>
                        <textarea id="contenido" name="contenido" required rows="8"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="estado">Estado *</label>
                        <select id="estado" name="estado" required>
                            <option value="borrador">Borrador</option>
                            <option value="publicado">Publicado</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Crear Aviso</button>
                </form>
            </div>
            
            <div class="admin-table">
                <h2>Avisos Existentes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($avisos as $aviso): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($aviso['titulo']); ?></td>
                                <td><?php echo ucfirst($aviso['estado']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($aviso['fecha_publicacion'])); ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $aviso['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('¿Eliminar?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>