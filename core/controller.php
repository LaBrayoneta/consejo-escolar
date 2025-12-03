<?php
class Controller {
    
     // Cargar vista
    protected function view($view, $data = []) {
        extract($data);
        
        // Verificar si es vista de admin
        if(strpos($view, 'admin/') === 0) {
            require_once '../app/views/' . $view . '.php';
        } else {
            require_once '../app/views/layout/header.php';
            require_once '../app/views/' . $view . '.php';
            require_once '../app/views/layout/footer.php';
        }
    }
    // Redireccionar
    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit();
    }

    // Verificar si está logueado
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Verificar autenticación
    protected function requireAuth() {
        if(!$this->isLoggedIn()) {
            $this->redirect('admin/login');
        }
    }

    // Verificar si es admin
    protected function requireAdmin() {
        $this->requireAuth();
        if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            $_SESSION['error'] = 'No tiene permisos para acceder a esta sección';
            $this->redirect('admin');
        }
    }

    // Obtener usuario actual
    protected function getCurrentUser() {
        if($this->isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'nombre' => $_SESSION['nombre'],
                'rol' => $_SESSION['rol']
            ];
        }
        return null;
    }

    // Validar CSRF Token
    protected function validateCSRF() {
        if(!isset($_POST['csrf_token']) || !CSRF::validateToken($_POST['csrf_token'])) {
            die('Token CSRF inválido. Por favor, recargue la página e intente nuevamente.');
        }
    }

    // Sanitizar entrada
    protected function sanitize($data) {
        if(is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }

    // Validar método HTTP
    protected function requireMethod($method = 'POST') {
        if($_SERVER['REQUEST_METHOD'] !== strtoupper($method)) {
            http_response_code(405);
            die('Método no permitido');
        }
    }

    // Flash messages
    protected function setFlash($type, $message) {
        $_SESSION['flash'][$type] = $message;
    }

    protected function getFlash($type) {
        if(isset($_SESSION['flash'][$type])) {
            $message = $_SESSION['flash'][$type];
            unset($_SESSION['flash'][$type]);
            return $message;
        }
        return null;
    }

    // Validar campos requeridos
    protected function validateRequired($fields, $data) {
        $errors = [];
        foreach($fields as $field) {
            if(!isset($data[$field]) || trim($data[$field]) === '') {
                $errors[$field] = "El campo {$field} es obligatorio";
            }
        }
        return $errors;
    }

    // Respuesta JSON
    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}