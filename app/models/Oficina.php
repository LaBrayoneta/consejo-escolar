<?php
// Este archivo debe estar en: app/models/Oficina.php

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

    // Buscar oficinas
    public function buscar($termino) {
        $termino = htmlspecialchars(strip_tags($termino));
        
        $sql = "SELECT * FROM oficinas 
                WHERE activo = 1 
                AND (nombre LIKE :termino OR descripcion LIKE :termino OR funciones LIKE :termino)
                ORDER BY orden ASC, nombre ASC";
        
        $stmt = $this->db->prepare($sql);
        $searchTerm = "%{$termino}%";
        $stmt->bindParam(':termino', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Reordenar oficinas
    public function reordenar($orden_array) {
        $this->db->beginTransaction();
        
        try {
            foreach($orden_array as $orden => $oficina_id) {
                $stmt = $this->db->prepare(
                    "UPDATE oficinas SET orden = :orden WHERE id = :id"
                );
                $stmt->bindParam(':orden', $orden);
                $stmt->bindParam(':id', $oficina_id);
                $stmt->execute();
            }
            
            $this->db->commit();
            return true;
        } catch(Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // Contar empleados por oficina
    public function contarEmpleados($oficina_id) {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) as total FROM empleados 
             WHERE oficina_id = :oficina_id AND activo = 1"
        );
        $stmt->bindParam(':oficina_id', $oficina_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}