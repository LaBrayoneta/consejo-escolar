<?php
class Usuario extends Model {
    protected $table = 'usuarios';

    // Autenticar usuario
    public function login($username, $password) {
        $stmt = $this->db->prepare(
            "SELECT * FROM usuarios 
             WHERE username = :username AND activo = 1"
        );
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }
        
        return false;
    }

    // Verificar si username existe
    public function usernameExists($username, $excludeId = null) {
        $sql = "SELECT id FROM usuarios WHERE username = :username";
        if($excludeId) {
            $sql .= " AND id != :id";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        if($excludeId) {
            $stmt->bindParam(':id', $excludeId);
        }
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
}
