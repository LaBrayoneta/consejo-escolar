<?php
class SobreNosotrosController extends Controller {
    
    public function index() {
        $consejeroModel = new Consejero();
        $infoModel = new InformacionInstitucional();
        
        $data = [
            'title' => 'Sobre Nosotros',
            'consejeros' => $consejeroModel->getAllConInstituciones(),
            'informacion' => $infoModel->getSecciones() // Esta línea es la clave
        ];
        
        // Debug: descomentar para verificar que hay datos
        // echo '<pre>'; print_r($data['informacion']); echo '</pre>'; die();
        
        $this->view('sobre-nosotros/index', $data);
    }
}