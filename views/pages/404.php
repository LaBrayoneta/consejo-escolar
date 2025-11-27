<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada</title>
    <link rel="stylesheet" href="/views/assets/css/style.css">
    <style>
        .error-container {
            min-height: 80vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: bold;
            color: var(--secondary-color);
            margin: 0;
            line-height: 1;
        }
        
        .error-message {
            font-size: 2rem;
            color: var(--primary-color);
            margin: 1rem 0;
        }
        
        .error-description {
            font-size: 1.1rem;
            color: var(--gray);
            margin-bottom: 2rem;
        }
        
        .error-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .error-btn {
            padding: 0.75rem 1.5rem;
            background-color: var(--secondary-color);
            color: var(--white);
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .error-btn:hover {
            background-color: #2980b9;
        }
        
        .error-btn-secondary {
            background-color: var(--gray);
        }
        
        .error-btn-secondary:hover {
            background-color: #7f8c8d;
        }
    </style>
</head>
<body>
    <?php include BASE_PATH . '/views/components/header.php'; ?>
    
    <main class="container">
        <div class="error-container">
            <h1 class="error-code">404</h1>
            <h2 class="error-message">Página no encontrada</h2>
            <p class="error-description">
                Lo sentimos, la página que estás buscando no existe o ha sido movida.
            </p>
            
            <div class="error-actions">
                <a href="/" class="error-btn">
                    🏠 Volver al Inicio
                </a>
                <a href="/home/oficinas" class="error-btn error-btn-secondary">
                    📋 Ver Oficinas
                </a>
                <a href="/home/about" class="error-btn error-btn-secondary">
                    👥 Sobre Nosotros
                </a>
            </div>
        </div>
    </main>
    
    <?php include BASE_PATH . '/views/components/footer.php'; ?>
</body>
</html>