?>

<?php
// index.php - Versión compatible sin mod_rewrite
session_start();

// Mostrar errores (solo desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración
define('BASE_PATH', __DIR__);
define('BASE_URL', '/index.php?page=');

// Autoload
spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/controllers/' . $class . '.php',
        BASE_PATH . '/config/' . $class . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Obtener la página solicitada
$page = $_GET['page'] ?? 'home';
$page = trim($page, '/');

// Si está vacío, mostrar home
if (empty($page)) {
    $page = 'home';
}

// Separar controlador y acción
$parts = explode('/', $page);
$controllerName = ucfirst($parts[0]) . 'Controller';
$action = isset($parts[1]) && !empty($parts[1]) ? $parts[1] : 'index';

// Debug - Comentar después de verificar
echo "<!-- Debug: Controller=$controllerName, Action=$action -->";

// Cargar controlador
$controllerPath = BASE_PATH . '/controllers/' . $controllerName . '.php';

if (file_exists($controllerPath)) {
    require_once $controllerPath;
    
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            // Método no existe
            header("HTTP/1.0 404 Not Found");
            echo "<h1>Error 404</h1>";
            echo "<p>El método <strong>$action</strong> no existe en <strong>$controllerName</strong></p>";
            if (file_exists(BASE_PATH . '/views/pages/404.php')) {
                require BASE_PATH . '/views/pages/404.php';
            }
        }
    } else {
        echo "<h1>Error</h1><p>La clase <strong>$controllerName</strong> no existe</p>";
    }
} else {
    // Controlador no existe
    header("HTTP/1.0 404 Not Found");
    echo "<h1>Error 404</h1>";
    echo "<p>El controlador <strong>$controllerName</strong> no existe en <strong>$controllerPath</strong></p>";
    if (file_exists(BASE_PATH . '/views/pages/404.php')) {
        require BASE_PATH . '/views/pages/404.php';
    }
}
?>
