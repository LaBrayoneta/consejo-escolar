<?php
class InformacionInstitucional extends Model {
    protected $table = 'informacion_institucional';

    // Obtener todas las secciones activas ordenadas
    public function getSecciones() {
        return $this->getAll('activo = 1', 'orden ASC');
    }

    // Obtener por clave de sección
    public function getBySeccion($seccion) {
        $stmt = $this->db->prepare(
            "SELECT * FROM informacion_institucional 
             WHERE seccion = :seccion AND activo = 1"
        );
        $stmt->bindParam(':seccion', $seccion);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Obtener todas (incluyendo inactivas) - para admin
    public function getAllSecciones() {
        return $this->getAll('', 'orden ASC');
    }
}