?>

<?php
// controllers/AuthController.php
class AuthController {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_role'] = $user['rol'];
                
                header('Location: /index.php?page=admin');
                exit;
            } else {
                $error = "Credenciales incorrectas";
            }
        }
        
        require BASE_PATH . '/views/pages/login.php';
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            
            if ($password !== $confirm) {
                $error = "Las contraseñas no coinciden";
            } else {
                $db = Database::getInstance()->getConnection();
                
                $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = ?");
                $stmt->execute([$email]);
                
                if ($stmt->fetch()) {
                    $error = "El email ya está registrado";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $db->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'usuario')");
                    
                    if ($stmt->execute([$nombre, $email, $hashedPassword])) {
                        $success = "Registro exitoso. Puedes iniciar sesión.";
                    } else {
                        $error = "Error al registrar usuario";
                    }
                }
            }
        }
        
        require BASE_PATH . '/views/pages/register.php';
    }
    
    public function logout() {
        session_destroy();
        header('Location: /index.php');
        exit;
    }
}
?>

