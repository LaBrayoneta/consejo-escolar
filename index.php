<?php
// index.php - Punto de entrada de la aplicación
session_start();

// Configuración de rutas
define('BASE_PATH', __DIR__);
define('BASE_URL', '/');

// Autoload de clases
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

// Enrutamiento simple
$request = $_SERVER['REQUEST_URI'];
$request = str_replace(BASE_URL, '', $request);
$request = explode('?', $request)[0];
$request = trim($request, '/');

// Si está vacío, es la página principal
if (empty($request)) {
    $request = 'home';
}

// Separar controlador y acción
$parts = explode('/', $request);
$controller = ucfirst($parts[0]) . 'Controller';
$action = isset($parts[1]) ? $parts[1] : 'index';

// Cargar el controlador
if (file_exists(BASE_PATH . '/controllers/' . $controller . '.php')) {
    $controllerObj = new $controller();
    if (method_exists($controllerObj, $action)) {
        $controllerObj->$action();
    } else {
        header("HTTP/1.0 404 Not Found");
        require BASE_PATH . '/views/pages/404.php';
    }
} else {
    header("HTTP/1.0 404 Not Found");
    require BASE_PATH . '/views/pages/404.php';
}
?>