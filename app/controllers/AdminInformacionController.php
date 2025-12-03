<?php
class AdminInformacionController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        $infoModel = new InformacionInstitucional();
        $data = [
            'title' => 'Gestionar Información Institucional',
            'user' => $this->getCurrentUser(),
            'secciones' => $infoModel->getAll('', 'orden ASC')
        ];
        
        $this->view('admin/informacion/index', $data);
    }
    
    public function crear() {
        $this->requireAuth();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $infoModel = new InformacionInstitucional();
            
            $data = [
                'seccion' => $this->sanitize($_POST['seccion']),
                'titulo' => $this->sanitize($_POST['titulo']),
                'contenido' => $_POST['contenido'], // No sanitizar para preservar saltos de línea
                'orden' => $_POST['orden'] ?? 0,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if($infoModel->create($data)) {
                $this->setFlash('success', 'Sección creada exitosamente');
                $this->redirect('admin/informacion');
            } else {
                $this->setFlash('error', 'Error al crear la sección');
            }
        }
        
        $data = [
            'title' => 'Crear Sección Institucional',
            'user' => $this->getCurrentUser()
        ];
        
        $this->view('admin/informacion/crear', $data);
    }
    
    public function editar($id) {
        $this->requireAuth();
        
        $infoModel = new InformacionInstitucional();
        $seccion = $infoModel->getById($id);
        
        if(!$seccion) {
            $this->setFlash('error', 'Sección no encontrada');
            $this->redirect('admin/informacion');
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $data = [
                'seccion' => $this->sanitize($_POST['seccion']),
                'titulo' => $this->sanitize($_POST['titulo']),
                'contenido' => $_POST['contenido'],
                'orden' => $_POST['orden'] ?? 0,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if($infoModel->update($id, $data)) {
                $this->setFlash('success', 'Sección actualizada exitosamente');
                $this->redirect('admin/informacion');
            } else {
                $this->setFlash('error', 'Error al actualizar la sección');
            }
        }
        
        $data = [
            'title' => 'Editar Sección Institucional',
            'user' => $this->getCurrentUser(),
            'seccion' => $seccion
        ];
        
        $this->view('admin/informacion/editar', $data);
    }
    
    public function eliminar($id) {
        $this->requireAuth();
        $this->requireAdmin();
        
        $infoModel = new InformacionInstitucional();
        
        if($infoModel->delete($id)) {
            $this->setFlash('success', 'Sección eliminada exitosamente');
        } else {
            $this->setFlash('error', 'Error al eliminar la sección');
        }
        
        $this->redirect('admin/informacion');
    }
    
    public function reordenar() {
        $this->requireAuth();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $orden = $_POST['orden'] ?? [];
            $infoModel = new InformacionInstitucional();
            
            $success = true;
            foreach($orden as $posicion => $id) {
                if(!$infoModel->update($id, ['orden' => $posicion])) {
                    $success = false;
                }
            }
            
            if($success) {
                $this->setFlash('success', 'Orden actualizado exitosamente');
            } else {
                $this->setFlash('error', 'Error al actualizar el orden');
            }
        }
        
        $this->redirect('admin/informacion');
    }
}