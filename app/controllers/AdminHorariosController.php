<?php
// app/controllers/AdminHorariosController.php
class AdminHorariosController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        $horarioModel = new Horario();
        $data = [
            'title' => 'Gestionar Horarios de Atención',
            'user' => $this->getCurrentUser(),
            'horarios' => $horarioModel->getAll('', 'orden ASC, tipo ASC'),
            'tipos' => $horarioModel->getTipos()
        ];
        
        $this->view('admin/horarios/index', $data);
    }
    
    public function crear() {
        $this->requireAuth();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $horarioModel = new Horario();
            
            $data = [
                'tipo' => $this->sanitize($_POST['tipo']),
                'titulo' => $this->sanitize($_POST['titulo']),
                'descripcion' => $_POST['descripcion'] ?? null,
                'dias_semana' => $this->sanitize($_POST['dias_semana']),
                'hora_inicio' => $_POST['hora_inicio'],
                'hora_fin' => $_POST['hora_fin'],
                'fecha_inicio' => !empty($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null,
                'fecha_fin' => !empty($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null,
                'orden' => (int)($_POST['orden'] ?? 0),
                'observaciones' => $_POST['observaciones'] ?? null,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            // Validar fechas si existen
            if ($data['fecha_inicio'] && $data['fecha_fin']) {
                if ($data['fecha_inicio'] > $data['fecha_fin']) {
                    $this->setFlash('error', 'La fecha de inicio debe ser anterior a la fecha de fin');
                    $data['title'] = 'Crear Horario';
                    $data['user'] = $this->getCurrentUser();
                    $data['tipos'] = $horarioModel->getTipos();
                    $data['horario'] = $data;
                    $this->view('admin/horarios/crear', $data);
                    return;
                }
                
                // Validar conflictos
                if (!$horarioModel->validarFechas($data['fecha_inicio'], $data['fecha_fin'])) {
                    $this->setFlash('error', 'Ya existe un horario activo para ese periodo de fechas');
                    $data['title'] = 'Crear Horario';
                    $data['user'] = $this->getCurrentUser();
                    $data['tipos'] = $horarioModel->getTipos();
                    $data['horario'] = $data;
                    $this->view('admin/horarios/crear', $data);
                    return;
                }
            }
            
            if($horarioModel->create($data)) {
                $this->setFlash('success', 'Horario creado exitosamente');
                $this->redirect('admin/horarios');
            } else {
                $this->setFlash('error', 'Error al crear el horario');
            }
        }
        
        $horarioModel = new Horario();
        $data = [
            'title' => 'Crear Horario',
            'user' => $this->getCurrentUser(),
            'tipos' => $horarioModel->getTipos()
        ];
        
        $this->view('admin/horarios/crear', $data);
    }
    
    public function editar($id) {
        $this->requireAuth();
        
        $horarioModel = new Horario();
        $horario = $horarioModel->getById($id);
        
        if(!$horario) {
            $this->setFlash('error', 'Horario no encontrado');
            $this->redirect('admin/horarios');
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $data = [
                'tipo' => $this->sanitize($_POST['tipo']),
                'titulo' => $this->sanitize($_POST['titulo']),
                'descripcion' => $_POST['descripcion'] ?? null,
                'dias_semana' => $this->sanitize($_POST['dias_semana']),
                'hora_inicio' => $_POST['hora_inicio'],
                'hora_fin' => $_POST['hora_fin'],
                'fecha_inicio' => !empty($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null,
                'fecha_fin' => !empty($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null,
                'orden' => (int)($_POST['orden'] ?? 0),
                'observaciones' => $_POST['observaciones'] ?? null,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            // Validar fechas
            if ($data['fecha_inicio'] && $data['fecha_fin']) {
                if ($data['fecha_inicio'] > $data['fecha_fin']) {
                    $this->setFlash('error', 'La fecha de inicio debe ser anterior a la fecha de fin');
                    $horario = array_merge($horario, $data);
                    $viewData = [
                        'title' => 'Editar Horario',
                        'user' => $this->getCurrentUser(),
                        'horario' => $horario,
                        'tipos' => $horarioModel->getTipos()
                    ];
                    $this->view('admin/horarios/editar', $viewData);
                    return;
                }
                
                // Validar conflictos (excluyendo el horario actual)
                if (!$horarioModel->validarFechas($data['fecha_inicio'], $data['fecha_fin'], $id)) {
                    $this->setFlash('error', 'Ya existe un horario activo para ese periodo de fechas');
                    $horario = array_merge($horario, $data);
                    $viewData = [
                        'title' => 'Editar Horario',
                        'user' => $this->getCurrentUser(),
                        'horario' => $horario,
                        'tipos' => $horarioModel->getTipos()
                    ];
                    $this->view('admin/horarios/editar', $viewData);
                    return;
                }
            }
            
            if($horarioModel->update($id, $data)) {
                $this->setFlash('success', 'Horario actualizado exitosamente');
                $this->redirect('admin/horarios');
            } else {
                $this->setFlash('error', 'Error al actualizar el horario');
            }
        }
        
        $data = [
            'title' => 'Editar Horario',
            'user' => $this->getCurrentUser(),
            'horario' => $horario,
            'tipos' => $horarioModel->getTipos()
        ];
        
        $this->view('admin/horarios/editar', $data);
    }
    
    public function eliminar($id) {
        $this->requireAuth();
        $this->requireAdmin();
        
        if(!$id) {
            $this->setFlash('error', 'ID de horario no válido');
            $this->redirect('admin/horarios');
        }
        
        $horarioModel = new Horario();
        $horario = $horarioModel->getById($id);
        
        if(!$horario) {
            $this->setFlash('error', 'Horario no encontrado');
            $this->redirect('admin/horarios');
        }
        
        if($horarioModel->delete($id)) {
            $this->setFlash('success', 'Horario eliminado exitosamente');
        } else {
            $this->setFlash('error', 'Error al eliminar el horario');
        }
        
        $this->redirect('admin/horarios');
    }
}