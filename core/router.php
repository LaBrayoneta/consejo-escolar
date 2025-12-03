<?php
class Router {
    private $controller = 'HomeController';
    private $method = 'index';
    private $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Verificar si es una ruta de admin
        if(isset($url[0]) && $url[0] === 'admin') {
            $this->handleAdminRoute($url);
        } else {
            $this->handlePublicRoute($url);
        }

        // Verificar que el controlador existe
        if(!class_exists($this->controller)) {
            $this->controller = 'HomeController';
            $this->method = 'index';
            $this->params = [];
        }

        // Instanciar controlador
        $this->controller = new $this->controller;

        // Verificar que el método existe
        if(!method_exists($this->controller, $this->method)) {
            $this->method = 'index';
        }

        // Llamar controlador y método con parámetros
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function handleAdminRoute($url) {
        // Remover 'admin' del inicio
        unset($url[0]);
        $url = array_values($url);

        // Si no hay nada más después de 'admin', usar AdminController
        if(empty($url)) {
            $this->controller = 'AdminController';
            require_once '../app/controllers/AdminController.php';
            return;
        }

        // Mapeo especial para rutas de eliminación y acciones
        $specialRoutes = [
            'eliminar_aviso' => ['AdminController', 'eliminar_aviso'],
            'editar_aviso' => ['AdminController', 'editar_aviso'],
            'crear_aviso' => ['AdminController', 'crear_aviso'],
            'avisos' => ['AdminController', 'avisos'],
        ];

        // Verificar si es una ruta especial
        if(isset($specialRoutes[$url[0]])) {
            list($controllerName, $methodName) = $specialRoutes[$url[0]];
            $this->controller = $controllerName;
            $this->method = $methodName;
            require_once '../app/controllers/' . $controllerName . '.php';
            unset($url[0]);
            $this->params = $url ? array_values($url) : [];
            return;
        }

        // Construir el nombre del controlador admin
        $controllerName = 'Admin' . ucfirst($url[0]) . 'Controller';
        $controllerFile = '../app/controllers/' . $controllerName . '.php';

        // Verificar si existe el controlador específico
        if(file_exists($controllerFile)) {
            $this->controller = $controllerName;
            require_once $controllerFile;
            unset($url[0]);
            
            // Verificar método
            if(isset($url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        } else {
            // Si no existe controlador específico, usar AdminController con método
            $this->controller = 'AdminController';
            require_once '../app/controllers/AdminController.php';
            
            if(isset($url[0])) {
                $this->method = $url[0];
                unset($url[0]);
            }
        }

        // Obtener parámetros restantes
        $this->params = $url ? array_values($url) : [];
    }

    private function handlePublicRoute($url) {
        // Mapa de URLs a controladores
        $routeMap = [
            'sobre-nosotros' => 'SobreNosotrosController',
            'avisos' => 'AvisosController',
            'oficinas' => 'OficinasController',
        ];

        if(isset($url[0]) && !empty($url[0])) {
            if(isset($routeMap[$url[0]])) {
                $controllerName = $routeMap[$url[0]];
                $controllerFile = '../app/controllers/' . $controllerName . '.php';
                
                if(file_exists($controllerFile)) {
                    $this->controller = $controllerName;
                    require_once $controllerFile;
                    unset($url[0]);
                }
            } else {
                $controllerName = ucfirst($url[0]) . 'Controller';
                $controllerFile = '../app/controllers/' . $controllerName . '.php';
                
                if(file_exists($controllerFile)) {
                    $this->controller = $controllerName;
                    require_once $controllerFile;
                    unset($url[0]);
                }
            }
        }

        if($this->controller === 'HomeController') {
            require_once '../app/controllers/HomeController.php';
        }

        if(isset($url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];
    }

    private function parseUrl() {
        if(isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}