<?php
// controllers/HomeController.php
class HomeController {
    
    public function index() {
        $db = Database::getInstance()->getConnection();
        
        // Obtener últimos avisos publicados
        $stmt = $db->prepare("SELECT * FROM avisos WHERE estado = 'publicado' ORDER BY fecha_publicacion DESC LIMIT 5");
        $stmt->execute();
        $avisos = $stmt->fetchAll();
        
        require BASE_PATH . '/views/pages/home.php';
    }
    
    public function about() {
        $db = Database::getInstance()->getConnection();
        
        // Obtener consejeros
        $stmt = $db->prepare("SELECT * FROM consejeros ORDER BY cargo");
        $stmt->execute();
        $consejeros = $stmt->fetchAll();
        
        require BASE_PATH . '/views/pages/about.php';
    }
    
    public function oficinas() {
        $db = Database::getInstance()->getConnection();
        
        // Obtener información de oficinas
        $stmt = $db->prepare("SELECT * FROM oficinas ORDER BY nombre");
        $stmt->execute();
        $oficinas = $stmt->fetchAll();
        
        require BASE_PATH . '/views/pages/oficinas.php';
    }
}