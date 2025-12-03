<?php
// Este archivo necesita ser creado en: app/controllers/AdminConsejerosController.php

class AdminConsejerosController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        $consejeroModel = new Consejero();
        $data = [
            'title' => 'Gestionar Consejeros',
            'user' => $this->getCurrentUser(),
            'consejeros' => $consejeroModel->getAllConInstituciones()
        ];
        
        $this->view('admin/consejeros/index', $data);
    }
    
    public function crear() {
        $this->requireAuth();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $consejeroModel = new Consejero();
            
            $data = [
                'nombre' => $_POST['nombre'],
                'cargo' => $_POST['cargo'],
                'email' => $_POST['email'] ?? null,
                'telefono' => $_POST['telefono'] ?? null,
                'biografia' => $_POST['biografia'] ?? null,
                'orden' => $_POST['orden'] ?? 0,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            // Manejar foto si se sube
            if(isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $uploadDir = '../public/uploads/consejeros/';
                if(!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('consejero_') . '.' . $extension;
                
                if(move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $filename)) {
                    $data['foto'] = $filename;
                }
            }
            
            if($consejeroModel->create($data)) {
                $this->redirect('admin/consejeros');
            }
        }
        
        $data = [
            'title' => 'Crear Consejero',
            'user' => $this->getCurrentUser()
        ];
        
        $this->view('admin/consejeros/crear', $data);
    }
    
    public function editar($id) {
        $this->requireAuth();
        
        $consejeroModel = new Consejero();
        $consejero = $consejeroModel->getById($id);
        
        if(!$consejero) {
            $this->redirect('admin/consejeros');
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $data = [
                'nombre' => $_POST['nombre'],
                'cargo' => $_POST['cargo'],
                'email' => $_POST['email'] ?? null,
                'telefono' => $_POST['telefono'] ?? null,
                'biografia' => $_POST['biografia'] ?? null,
                'orden' => $_POST['orden'] ?? 0,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            // Manejar foto si se sube
            if(isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $uploadDir = '../public/uploads/consejeros/';
                if(!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('consejero_') . '.' . $extension;
                
                if(move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $filename)) {
                    // Eliminar foto anterior si existe
                    if($consejero['foto'] && file_exists($uploadDir . $consejero['foto'])) {
                        unlink($uploadDir . $consejero['foto']);
                    }
                    $data['foto'] = $filename;
                }
            }
            
            if($consejeroModel->update($id, $data)) {
                $this->redirect('admin/consejeros');
            }
        }
        
        $data = [
            'title' => 'Editar Consejero',
            'user' => $this->getCurrentUser(),
            'consejero' => $consejero
        ];
        
        $this->view('admin/consejeros/editar', $data);
    }
    
    public function eliminar($id) {
        $this->requireAuth();
        $this->requireAdmin();
        
        $consejeroModel = new Consejero();
        $consejero = $consejeroModel->getById($id);
        
        // Eliminar foto si existe
        if($consejero && $consejero['foto']) {
            $fotoPath = '../public/uploads/consejeros/' . $consejero['foto'];
            if(file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }
        
        $consejeroModel->delete($id);
        $this->redirect('admin/consejeros');
    }
    
    // Asignar instituciones a consejero
    public function instituciones($consejero_id) {
        $this->requireAuth();
        
        $consejeroModel = new Consejero();
        $consejero = $consejeroModel->getConInstituciones($consejero_id);
        
        if(!$consejero) {
            $this->redirect('admin/consejeros');
        }
        
        // Obtener todas las instituciones disponibles
        $institucionModel = new Institucion();
        $instituciones = $institucionModel->getAll('activo = 1', 'nombre ASC');
        
        $data = [
            'title' => 'Instituciones - ' . $consejero['nombre'],
            'user' => $this->getCurrentUser(),
            'consejero' => $consejero,
            'instituciones' => $instituciones
        ];
        
        $this->view('admin/consejeros/instituciones', $data);
    }
}