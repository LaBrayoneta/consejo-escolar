<?php
// Este archivo debe crearse en: app/models/Empleado.php

class Empleado extends Model {
    protected $table = 'empleados';

    // Obtener empleados activos
    public function getActivos() {
        return $this->getAll('activo = 1', 'orden ASC, nombre ASC');
    }

    // Obtener empleados por oficina
    public function getByOficina($oficina_id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM empleados 
             WHERE oficina_id = :oficina_id AND activo = 1
             ORDER BY orden ASC, nombre ASC"
        );
        $stmt->bindParam(':oficina_id', $oficina_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener empleado con información de su oficina
    public function getConOficina($id) {
        $stmt = $this->db->prepare(
            "SELECT e.*, o.nombre as oficina_nombre 
             FROM empleados e
             INNER JOIN oficinas o ON e.oficina_id = o.id
             WHERE e.id = :id"
        );
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear empleado
    public function create($data) {
        // Asignar orden automáticamente si no se especifica
        if(!isset($data['orden']) || $data['orden'] === null) {
            $stmt = $this->db->prepare(
                "SELECT MAX(orden) as max_orden FROM empleados WHERE oficina_id = :oficina_id"
            );
            $stmt->bindParam(':oficina_id', $data['oficina_id']);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $data['orden'] = ($result['max_orden'] ?? 0) + 1;
        }
        
        return parent::create($data);
    }

    // Buscar empleados
    public function buscar($termino) {
        $termino = htmlspecialchars(strip_tags($termino));
        
        $sql = "SELECT e.*, o.nombre as oficina_nombre 
                FROM empleados e
                INNER JOIN oficinas o ON e.oficina_id = o.id
                WHERE e.activo = 1 
                AND (e.nombre LIKE :termino OR e.cargo LIKE :termino OR o.nombre LIKE :termino)
                ORDER BY e.nombre ASC";
        
        $stmt = $this->db->prepare($sql);
        $searchTerm = "%{$termino}%";
        $stmt->bindParam(':termino', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Reordenar empleados de una oficina
    public function reordenar($oficina_id, $orden_array) {
        $this->db->beginTransaction();
        
        try {
            foreach($orden_array as $orden => $empleado_id) {
                $stmt = $this->db->prepare(
                    "UPDATE empleados SET orden = :orden WHERE id = :id AND oficina_id = :oficina_id"
                );
                $stmt->bindParam(':orden', $orden);
                $stmt->bindParam(':id', $empleado_id);
                $stmt->bindParam(':oficina_id', $oficina_id);
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
    public function contarPorOficina($oficina_id) {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) as total FROM empleados WHERE oficina_id = :oficina_id AND activo = 1"
        );
        $stmt->bindParam(':oficina_id', $oficina_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}