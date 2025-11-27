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
        $aviso = $avisoModel->getById($id);
        
        if(!$aviso || $aviso['activo'] != 1) {
            header("HTTP/1.0 404 Not Found");
            $this->view('errors/404');
            return;
        }
        
        $data = [
            'title' => $aviso['titulo'],
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