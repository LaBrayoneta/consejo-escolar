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
}