<?php
class AdminController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        $avisoModel = new Aviso();
        $oficinaModel = new Oficina();
        $consejeroModel = new Consejero();
        $infoModel = new InformacionInstitucional();
        
        $data = [
            'title' => 'Panel de Administración',
            'user' => $this->getCurrentUser(),
            'stats' => [
                'total_avisos' => count($avisoModel->getAll()),
                'total_oficinas' => count($oficinaModel->getAll()),
                'total_consejeros' => count($consejeroModel->getAll()),
                'total_info_institucional' => count($infoModel->getAll())
            ]
        ];
        
        $this->view('admin/dashboard', $data);
    }
    
    public function login() {
        if($this->isLoggedIn()) {
            $this->redirect('admin');
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->login($username, $password);
            
            if($usuario) {
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['username'] = $usuario['username'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['rol'] = $usuario['rol'];
                
                $this->redirect('admin');
            } else {
                $data = [
                    'title' => 'Iniciar Sesión',
                    'error' => 'Usuario o contraseña incorrectos'
                ];
                $this->view('admin/login', $data);
            }
        } else {
            $data = ['title' => 'Iniciar Sesión'];
            $this->view('admin/login', $data);
        }
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('admin/login');
    }
    
    // CRUD de Avisos
    public function avisos() {
        $this->requireAuth();
        
        $avisoModel = new Aviso();
        $data = [
            'title' => 'Gestionar Avisos',
            'user' => $this->getCurrentUser(),
            'avisos' => $avisoModel->getAll()
        ];
        
        $this->view('admin/avisos/index', $data);
    }
    
    public function crear_aviso() {
        $this->requireAuth();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar CSRF solo en POST
            $this->validateCSRF();
            
            $avisoModel = new Aviso();
            
            $data = [
                'titulo' => $_POST['titulo'],
                'contenido' => $_POST['contenido'],
                'destacado' => isset($_POST['destacado']) ? 1 : 0,
                'usuario_id' => $_SESSION['user_id']
            ];
            
            if($avisoModel->create($data)) {
                $this->redirect('admin/avisos');
            }
        }
        
        $data = [
            'title' => 'Crear Aviso',
            'user' => $this->getCurrentUser()
        ];
        
        $this->view('admin/avisos/crear', $data);
    }
    
    public function editar_aviso($id) {
        $this->requireAuth();
        
        $avisoModel = new Aviso();
        $aviso = $avisoModel->getById($id);
        
        if(!$aviso) {
            $this->redirect('admin/avisos');
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCSRF();
            
            $data = [
                'titulo' => $_POST['titulo'],
                'contenido' => $_POST['contenido'],
                'destacado' => isset($_POST['destacado']) ? 1 : 0
            ];
            
            if($avisoModel->update($id, $data)) {
                $this->redirect('admin/avisos');
            }
        }
        
        $data = [
            'title' => 'Editar Aviso',
            'user' => $this->getCurrentUser(),
            'aviso' => $aviso
        ];
        
        $this->view('admin/avisos/editar', $data);
    }
    
    public function eliminar_aviso($id) {
        $this->requireAuth();
        $this->requireAdmin();
        
        $avisoModel = new Aviso();
        $avisoModel->delete($id);
        
        $this->redirect('admin/avisos');
    }
}