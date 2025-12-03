<?php

class Institucion extends Model {
    protected $table = 'instituciones';

    // Obtener instituciones activas
    public function getActivas() {
        return $this->getAll('activo = 1', 'nombre ASC');
    }

    // Obtener instituciones por nivel
    public function getByNivel($nivel) {
        $stmt = $this->db->prepare(
            "SELECT * FROM instituciones 
             WHERE nivel = :nivel AND activo = 1
             ORDER BY nombre ASC"
        );
        $stmt->bindParam(':nivel', $nivel);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener institución con su consejero asignado
    public function getConConsejero($id) {
        $institucion = $this->getById($id);
        
        if($institucion) {
            $stmt = $this->db->prepare(
                "SELECT c.* 
                 FROM consejeros c
                 INNER JOIN consejero_institucion ci ON c.id = ci.consejero_id
                 WHERE ci.institucion_id = :id AND ci.activo = 1
                 LIMIT 1"
            );
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $institucion['consejero'] = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        return $institucion;
    }

    // Obtener todas las instituciones con sus consejeros
    public function getAllConConsejeros() {
        $instituciones = $this->getActivas();
        
        foreach($instituciones as &$institucion) {
            $stmt = $this->db->prepare(
                "SELECT c.* 
                 FROM consejeros c
                 INNER JOIN consejero_institucion ci ON c.id = ci.consejero_id
                 WHERE ci.institucion_id = :id AND ci.activo = 1
                 LIMIT 1"
            );
            $stmt->bindParam(':id', $institucion['id']);
            $stmt->execute();
            $institucion['consejero'] = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        return $instituciones;
    }

    // Asignar consejero a institución
    public function asignarConsejero($institucion_id, $consejero_id) {
        // Primero desactivar asignaciones previas
        $stmt = $this->db->prepare(
            "UPDATE consejero_institucion 
             SET activo = 0 
             WHERE institucion_id = :institucion_id"
        );
        $stmt->bindParam(':institucion_id', $institucion_id);
        $stmt->execute();
        
        // Verificar si ya existe la relación
        $stmt = $this->db->prepare(
            "SELECT id FROM consejero_institucion 
             WHERE institucion_id = :institucion_id 
             AND consejero_id = :consejero_id"
        );
        $stmt->bindParam(':institucion_id', $institucion_id);
        $stmt->bindParam(':consejero_id', $consejero_id);
        $stmt->execute();
        
        if($stmt->fetch()) {
            // Actualizar existente
            $stmt = $this->db->prepare(
                "UPDATE consejero_institucion 
                 SET activo = 1 
                 WHERE institucion_id = :institucion_id 
                 AND consejero_id = :consejero_id"
            );
            $stmt->bindParam(':institucion_id', $institucion_id);
            $stmt->bindParam(':consejero_id', $consejero_id);
            return $stmt->execute();
        } else {
            // Crear nueva relación
            $stmt = $this->db->prepare(
                "INSERT INTO consejero_institucion 
                 (consejero_id, institucion_id, fecha_asignacion, activo) 
                 VALUES (:consejero_id, :institucion_id, CURDATE(), 1)"
            );
            $stmt->bindParam(':consejero_id', $consejero_id);
            $stmt->bindParam(':institucion_id', $institucion_id);
            return $stmt->execute();
        }
    }

    // Desasignar consejero de institución
    public function desasignarConsejero($institucion_id) {
        $stmt = $this->db->prepare(
            "UPDATE consejero_institucion 
             SET activo = 0 
             WHERE institucion_id = :institucion_id"
        );
        $stmt->bindParam(':institucion_id', $institucion_id);
        return $stmt->execute();
    }

    // Obtener niveles disponibles
    public function getNiveles() {
        $stmt = $this->db->prepare(
            "SELECT DISTINCT nivel 
             FROM instituciones 
             WHERE activo = 1 
             ORDER BY nivel ASC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Buscar instituciones
    public function buscar($termino) {
        $termino = htmlspecialchars(strip_tags($termino));
        
        $sql = "SELECT * FROM instituciones 
                WHERE activo = 1 
                AND (nombre LIKE :termino OR direccion LIKE :termino OR nivel LIKE :termino)
                ORDER BY nombre ASC";
        
        $stmt = $this->db->prepare($sql);
        $searchTerm = "%{$termino}%";
        $stmt->bindParam(':termino', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}