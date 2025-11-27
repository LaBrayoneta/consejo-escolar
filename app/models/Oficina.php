<?php
class Oficina extends Model {
    protected $table = 'oficinas';

    // Obtener oficinas activas ordenadas
    public function getActivas() {
        return $this->getAll('activo = 1', 'orden ASC, nombre ASC');
    }

    // Obtener oficina con empleados
    public function getConEmpleados($id) {
        $oficina = $this->getById($id);
        
        if($oficina) {
            $stmt = $this->db->prepare(
                "SELECT * FROM empleados 
                 WHERE oficina_id = :id AND activo = 1 
                 ORDER BY orden ASC, nombre ASC"
            );
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $oficina['empleados'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $oficina;
    }

    // Obtener todas las oficinas con sus empleados
    public function getAllConEmpleados() {
        $oficinas = $this->getActivas();
        
        foreach($oficinas as &$oficina) {
            $stmt = $this->db->prepare(
                "SELECT * FROM empleados 
                 WHERE oficina_id = :id AND activo = 1 
                 ORDER BY orden ASC, nombre ASC"
            );
            $stmt->bindParam(':id', $oficina['id']);
            $stmt->execute();
            $oficina['empleados'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $oficinas;
    }
}
