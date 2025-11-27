<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Oficinas - Admin</title>
    <link rel="stylesheet" href="/views/assets/css/style.css">
    <link rel="stylesheet" href="/views/assets/css/admin.css">
</head>
<body>
    <div class="admin-layout">
        <?php include BASE_PATH . '/views/components/admin_sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="admin-header">
                <h1>Gestión de Oficinas</h1>
            </div>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <!-- Formulario para crear oficina -->
            <div class="admin-form">
                <h2>Crear Nueva Oficina</h2>
                <form method="POST" action="/admin/oficinas">
                    <input type="hidden" name="action" value="create">
                    
                    <div class="form-group">
                        <label for="nombre">Nombre de la Oficina</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="descripcion">Descripción / Funciones</label>
                        <textarea id="descripcion" name="descripcion" required></textarea>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="email">Email de Contacto</label>
                            <input type="email" id="email" name="email">
                        </div>
                        
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" id="telefono" name="telefono">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Crear Oficina</button>
                </form>
            </div>
            
            <!-- Lista de oficinas -->
            <div class="admin-table">
                <h2>Oficinas Existentes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($oficinas as $oficina): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($oficina['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($oficina['email']); ?></td>
                                <td><?php echo htmlspecialchars($oficina['telefono']); ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $oficina['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('¿Eliminar esta oficina?')">
                                            Eliminar
                                        </button>
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