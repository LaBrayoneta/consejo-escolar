<?php
class Aviso extends Model {
    protected $table = 'avisos';

    // Sobrescribir getAll para incluir información del autor
    public function getAll($where = '', $orderBy = 'id DESC') {
        $sql = "SELECT a.*, u.nombre as autor 
                FROM {$this->table} a 
                LEFT JOIN usuarios u ON a.usuario_id = u.id";
        
        if($where) {
            $sql .= " WHERE {$where}";
        }
        $sql .= " ORDER BY {$orderBy}";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener avisos activos
    public function getActivos($limit = null) {
        $sql = "SELECT a.*, u.nombre as autor 
                FROM avisos a 
                INNER JOIN usuarios u ON a.usuario_id = u.id 
                WHERE a.activo = 1 
                ORDER BY a.created_at DESC";
        
        if($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener avisos destacados
    public function getDestacados($limit = 3) {
        $sql = "SELECT a.*, u.nombre as autor 
                FROM avisos a 
                INNER JOIN usuarios u ON a.usuario_id = u.id 
                WHERE a.activo = 1 AND a.destacado = 1 
                ORDER BY a.created_at DESC 
                LIMIT {$limit}";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
public function getById($id) {
    $stmt = $this->db->prepare(
        "SELECT a.*, u.nombre as autor 
         FROM {$this->table} a 
         LEFT JOIN usuarios u ON a.usuario_id = u.id 
         WHERE a.id = :id"
    );
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
    // Buscar avisos
    public function buscar($termino) {
        // Sanitizar entrada
        $termino = htmlspecialchars(strip_tags($termino));
        
        $sql = "SELECT a.*, u.nombre as autor 
                FROM avisos a 
                INNER JOIN usuarios u ON a.usuario_id = u.id 
                WHERE a.activo = 1 
                AND (a.titulo LIKE :termino OR a.contenido LIKE :termino)
                ORDER BY a.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $searchTerm = "%{$termino}%";
        $stmt->bindParam(':termino', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}