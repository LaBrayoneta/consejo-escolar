<?php
// controllers/AdminController.php
class AdminController {
    
    private function checkAuth() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /auth/login');
            exit;
        }
    }
    
    public function index() {
        $this->checkAuth();
        
        $db = Database::getInstance()->getConnection();
        
        // Estadísticas
        $stmt = $db->query("SELECT COUNT(*) as total FROM avisos");
        $totalAvisos = $stmt->fetch()['total'];
        
        $stmt = $db->query("SELECT COUNT(*) as total FROM oficinas");
        $totalOficinas = $stmt->fetch()['total'];
        
        require BASE_PATH . '/views/pages/admin.php';
    }
    
    public function avisos() {
        $this->checkAuth();
        
        $db = Database::getInstance()->getConnection();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            
            if ($action === 'create') {
                $titulo = $_POST['titulo'] ?? '';
                $contenido = $_POST['contenido'] ?? '';
                $estado = $_POST['estado'] ?? 'borrador';
                
                $stmt = $db->prepare("INSERT INTO avisos (titulo, contenido, estado, fecha_publicacion, autor_id) VALUES (?, ?, ?, NOW(), ?)");
                $stmt->execute([$titulo, $contenido, $estado, $_SESSION['user_id']]);
                
                $success = "Aviso creado exitosamente";
            } elseif ($action === 'delete') {
                $id = $_POST['id'] ?? 0;
                $stmt = $db->prepare("DELETE FROM avisos WHERE id = ?");
                $stmt->execute([$id]);
                
                $success = "Aviso eliminado";
            }
        }
        
        // Obtener todos los avisos
        $stmt = $db->query("SELECT a.*, u.nombre as autor FROM avisos a LEFT JOIN usuarios u ON a.autor_id = u.id ORDER BY a.fecha_publicacion DESC");
        $avisos = $stmt->fetchAll();
        
        require BASE_PATH . '/views/pages/admin_avisos.php';
    }
    
    public function oficinas() {
        $this->checkAuth();
        
        $db = Database::getInstance()->getConnection();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            
            if ($action === 'create' || $action === 'update') {
                $id = $_POST['id'] ?? null;
                $nombre = $_POST['nombre'] ?? '';
                $descripcion = $_POST['descripcion'] ?? '';
                $email = $_POST['email'] ?? '';
                $telefono = $_POST['telefono'] ?? '';
                
                if ($action === 'create') {
                    $stmt = $db->prepare("INSERT INTO oficinas (nombre, descripcion, email, telefono) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$nombre, $descripcion, $email, $telefono]);
                } else {
                    $stmt = $db->prepare("UPDATE oficinas SET nombre = ?, descripcion = ?, email = ?, telefono = ? WHERE id = ?");
                    $stmt->execute([$nombre, $descripcion, $email, $telefono, $id]);
                }
                
                $success = "Oficina guardada exitosamente";
            } elseif ($action === 'delete') {
                $id = $_POST['id'] ?? 0;
                $stmt = $db->prepare("DELETE FROM oficinas WHERE id = ?");
                $stmt->execute([$id]);
                
                $success = "Oficina eliminada";
            }
        }
        
        // Obtener todas las oficinas
        $stmt = $db->query("SELECT * FROM oficinas ORDER BY nombre");
        $oficinas = $stmt->fetchAll();
        
        require BASE_PATH . '/views/pages/admin_oficinas.php';
    }
}
?>