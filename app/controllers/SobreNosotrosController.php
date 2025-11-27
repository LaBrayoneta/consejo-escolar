<?php
class SobreNosotrosController extends Controller {
    
    public function index() {
        $consejeroModel = new Consejero();
        $infoModel = new InformacionInstitucional();
        
        $data = [
            'title' => 'Sobre Nosotros',
            'consejeros' => $consejeroModel->getAllConInstituciones(),
            'informacion' => $infoModel->getSecciones()
        ];
        
        $this->view('sobre-nosotros/index', $data);
    }
}