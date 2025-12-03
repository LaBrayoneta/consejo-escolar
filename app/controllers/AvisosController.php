<?php
class AvisosController extends Controller {
    
    public function index() {
        $avisoModel = new Aviso();
        
        $data = [
            'title' => 'Avisos y Novedades',
            'avisos' => $avisoModel->getActivos()
        ];
        
        $this->view('avisos/index', $data);
    }
    
    public function detalle($id) {
        $avisoModel = new Aviso();
        
        // Obtener el aviso con información del autor
        $aviso = $avisoModel->getById($id);
        
        // Validar que el aviso existe y está activo
        if(!$aviso) {
            header("HTTP/1.0 404 Not Found");
            $data = ['title' => 'Aviso no encontrado'];
            $this->view('errors/404', $data);
            return;
        }
        
        if($aviso['activo'] != 1) {
            header("HTTP/1.0 404 Not Found");
            $data = ['title' => 'Aviso no disponible'];
            $this->view('errors/404', $data);
            return;
        }
        
        // Obtener información del autor si existe
        if(isset($aviso['usuario_id']) && $aviso['usuario_id']) {
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->getById($aviso['usuario_id']);
            if($usuario) {
                $aviso['autor'] = $usuario['nombre'];
            }
        }
        
        $data = [
            'title' => $aviso['titulo'] . ' - Consejo Escolar',
            'aviso' => $aviso
        ];
        
        $this->view('avisos/detalle', $data);
    }
    
    public function buscar() {
        $avisoModel = new Aviso();
        $termino = isset($_GET['q']) ? $_GET['q'] : '';
        
        $data = [
            'title' => 'Buscar Avisos',
            'termino' => $termino,
            'avisos' => $termino ? $avisoModel->buscar($termino) : []
        ];
        
        $this->view('avisos/buscar', $data);
    }
}