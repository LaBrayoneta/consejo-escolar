<?php
class Consejero extends Model {
    protected $table = 'consejeros';

    // Obtener consejeros activos
    public function getActivos() {
        return $this->getAll('activo = 1', 'orden ASC, nombre ASC');
    }

    // Obtener consejero con instituciones asignadas
    public function getConInstituciones($id) {
        $consejero = $this->getById($id);
        
        if($consejero) {
            $stmt = $this->db->prepare(
                "SELECT i.* 
                 FROM instituciones i
                 INNER JOIN consejero_institucion ci ON i.id = ci.institucion_id
                 WHERE ci.consejero_id = :id AND ci.activo = 1
                 ORDER BY i.nombre ASC"
            );
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $consejero['instituciones'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $consejero;
    }

    // Obtener todos los consejeros con instituciones
    public function getAllConInstituciones() {
        $consejeros = $this->getActivos();
        
        foreach($consejeros as &$consejero) {
            $stmt = $this->db->prepare(
                "SELECT i.* 
                 FROM instituciones i
                 INNER JOIN consejero_institucion ci ON i.id = ci.institucion_id
                 WHERE ci.consejero_id = :id AND ci.activo = 1
                 ORDER BY i.nombre ASC"
            );
            $stmt->bindParam(':id', $consejero['id']);
            $stmt->execute();
            $consejero['instituciones'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $consejeros;
    }
}