<?php
// Configuración general del sitio
define('SITE_NAME', 'Consejo Escolar');
define('BASE_URL', 'http://localhost/consejo-escolar/public/');
define('ADMIN_URL', BASE_URL . 'admin/');

// Zona horaria
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoload de clases
spl_autoload_register(function($class) {
    $paths = [
        '../core/' . $class . '.php',
        '../app/models/' . $class . '.php',
        '../app/controllers/' . $class . '.php'
    ];
    
    foreach($paths as $path) {
        if(file_exists($path)) {
            require_once $path;
            return;
        }
    }
});