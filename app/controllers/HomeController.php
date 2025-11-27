<?php
class HomeController extends Controller {
    
    public function index() {
        $avisoModel = new Aviso();
        
        $data = [
            'title' => 'Inicio',
            'avisosDestacados' => $avisoModel->getDestacados(3),
            'ultimosAvisos' => $avisoModel->getActivos(6)
        ];
        
        $this->view('home/index', $data);
    }
}