<?php
// Este archivo debe crearse en: app/controllers/AdminInstitucionesController.php

class AdminInstitucionesController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        $institucionModel = new Institucion();
        $data = [
            'title' => 'Gestionar Instituciones',
            'user' => $this->getCurrentUser(),
            'instituciones' => $institucionModel->getAllConConsejeros()
        ];
        
        $this->view('admin/instituciones/index', $data);
    }
    
    public function crear() {
        $this->requireAuth();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $institucionModel = new Institucion();
            
            $data = [
                'nombre' => $_POST['nombre'],
                'nivel' => $_POST['nivel'],
                'direccion' => $_POST['direccion'] ?? null,
                'telefono' => $_POST['telefono'] ?? null,
                'email' => $_POST['email'] ?? null,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if($institucionModel->create($data)) {
                $this->redirect('admin/instituciones');
            }
        }
        
        $data = [
            'title' => 'Crear Institución',
            'user' => $this->getCurrentUser()
        ];
        
        $this->view('admin/instituciones/crear', $data);
    }
    
    public function editar($id) {
        $this->requireAuth();
        
        $institucionModel = new Institucion();
        $institucion = $institucionModel->getById($id);
        
        if(!$institucion) {
            $this->redirect('admin/instituciones');
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $data = [
                'nombre' => $_POST['nombre'],
                'nivel' => $_POST['nivel'],
                'direccion' => $_POST['direccion'] ?? null,
                'telefono' => $_POST['telefono'] ?? null,
                'email' => $_POST['email'] ?? null,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if($institucionModel->update($id, $data)) {
                $this->redirect('admin/instituciones');
            }
        }
        
        $data = [
            'title' => 'Editar Institución',
            'user' => $this->getCurrentUser(),
            'institucion' => $institucion
        ];
        
        $this->view('admin/instituciones/editar', $data);
    }
    
    public function eliminar($id) {
        $this->requireAuth();
        $this->requireAdmin();
        
        $institucionModel = new Institucion();
        $institucionModel->delete($id);
        
        $this->redirect('admin/instituciones');
    }
    
    // Asignar consejero a institución
    public function asignarConsejero($id) {
        $this->requireAuth();
        
        $institucionModel = new Institucion();
        $institucion = $institucionModel->getConConsejero($id);
        
        if(!$institucion) {
            $this->redirect('admin/instituciones');
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            if(isset($_POST['consejero_id']) && $_POST['consejero_id']) {
                $institucionModel->asignarConsejero($id, $_POST['consejero_id']);
            } else {
                $institucionModel->desasignarConsejero($id);
            }
            
            $this->redirect('admin/instituciones');
        }
        
        // Obtener todos los consejeros
        $consejeroModel = new Consejero();
        $consejeros = $consejeroModel->getActivos();
        
        $data = [
            'title' => 'Asignar Consejero - ' . $institucion['nombre'],
            'user' => $this->getCurrentUser(),
            'institucion' => $institucion,
            'consejeros' => $consejeros
        ];
        
        $this->view('admin/instituciones/asignar_consejero', $data);
    }
}