<?php
class OficinasController extends Controller {
    
    public function index() {
        $oficinaModel = new Oficina();
        
        $data = [
            'title' => 'Nuestras Oficinas',
            'oficinas' => $oficinaModel->getAllConEmpleados()
        ];
        
        $this->view('oficinas/index', $data);
    }
}