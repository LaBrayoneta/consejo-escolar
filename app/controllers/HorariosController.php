<?php
// app/controllers/HorariosController.php
class HorariosController extends Controller {
    
    public function index() {
        $horarioModel = new Horario();
        
        // Obtener horario actual vigente
        $horarioActual = $horarioModel->getHorarioActual();
        
        // Obtener todos los horarios vigentes
        $horariosVigentes = $horarioModel->getHorariosVigentes();
        
        // Obtener todos los horarios (para mostrar información completa)
        $todosHorarios = $horarioModel->getActivos();
        
        $data = [
            'title' => 'Horarios de Atención',
            'horarioActual' => $horarioActual ? $horarioModel->formatearHorario($horarioActual) : null,
            'horariosVigentes' => array_map(function($h) use ($horarioModel) {
                return $horarioModel->formatearHorario($h);
            }, $horariosVigentes),
            'todosHorarios' => array_map(function($h) use ($horarioModel) {
                return $horarioModel->formatearHorario($h);
            }, $todosHorarios)
        ];
        
        $this->view('horarios/index', $data);
    }

    /**
     * Widget de horario para incluir en otras páginas
     */
    public function widget() {
        $horarioModel = new Horario();
        $horarioActual = $horarioModel->getHorarioActual();
        
        if ($horarioActual) {
            return $horarioModel->formatearHorario($horarioActual);
        }
        
        return null;
    }
}