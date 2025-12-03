<?php
// Este archivo necesita ser creado en: app/controllers/AdminOficinasController.php

class AdminOficinasController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        $oficinaModel = new Oficina();
        $data = [
            'title' => 'Gestionar Oficinas',
            'user' => $this->getCurrentUser(),
            'oficinas' => $oficinaModel->getAllConEmpleados()
        ];
        
        $this->view('admin/oficinas/index', $data);
    }
    
    public function crear() {
        $this->requireAuth();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $oficinaModel = new Oficina();
            
            $data = [
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion'],
                'funciones' => $_POST['funciones'],
                'email_principal' => $_POST['email_principal'],
                'email_secundario' => $_POST['email_secundario'] ?? null,
                'telefono' => $_POST['telefono'] ?? null,
                'ubicacion' => $_POST['ubicacion'] ?? null,
                'orden' => $_POST['orden'] ?? 0,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if($oficinaModel->create($data)) {
                $this->redirect('admin/oficinas');
            }
        }
        
        $data = [
            'title' => 'Crear Oficina',
            'user' => $this->getCurrentUser()
        ];
        
        $this->view('admin/oficinas/crear', $data);
    }
    
    public function editar($id) {
        $this->requireAuth();
        
        $oficinaModel = new Oficina();
        $oficina = $oficinaModel->getById($id);
        
        if(!$oficina) {
            $this->redirect('admin/oficinas');
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $data = [
                'nombre' => $_POST['nombre'],
                'descripcion' => $_POST['descripcion'],
                'funciones' => $_POST['funciones'],
                'email_principal' => $_POST['email_principal'],
                'email_secundario' => $_POST['email_secundario'] ?? null,
                'telefono' => $_POST['telefono'] ?? null,
                'ubicacion' => $_POST['ubicacion'] ?? null,
                'orden' => $_POST['orden'] ?? 0,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if($oficinaModel->update($id, $data)) {
                $this->redirect('admin/oficinas');
            }
        }
        
        $data = [
            'title' => 'Editar Oficina',
            'user' => $this->getCurrentUser(),
            'oficina' => $oficina
        ];
        
        $this->view('admin/oficinas/editar', $data);
    }
    
    public function eliminar($id) {
        $this->requireAuth();
        $this->requireAdmin();
        
        $oficinaModel = new Oficina();
        $oficinaModel->delete($id);
        
        $this->redirect('admin/oficinas');
    }
    
    // Gestión de empleados
    public function empleados($oficina_id) {
        $this->requireAuth();
        
        $oficinaModel = new Oficina();
        $oficina = $oficinaModel->getConEmpleados($oficina_id);
        
        if(!$oficina) {
            $this->redirect('admin/oficinas');
        }
        
        $data = [
            'title' => 'Empleados - ' . $oficina['nombre'],
            'user' => $this->getCurrentUser(),
            'oficina' => $oficina
        ];
        
        $this->view('admin/oficinas/empleados', $data);
    }
}