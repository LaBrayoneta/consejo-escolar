<?php
// app/models/Horario.php
class Horario extends Model {
    protected $table = 'horarios_atencion';

    /**
     * Obtener horarios activos ordenados
     */
    public function getActivos() {
        return $this->getAll('activo = 1', 'orden ASC, id ASC');
    }

    /**
     * Obtener el horario vigente actual según la fecha
     */
    public function getHorarioActual() {
        $sql = "SELECT * FROM {$this->table} 
                WHERE activo = 1 
                AND (
                    (fecha_inicio IS NULL AND fecha_fin IS NULL) 
                    OR 
                    (CURDATE() BETWEEN fecha_inicio AND fecha_fin)
                )
                ORDER BY 
                    CASE 
                        WHEN fecha_inicio IS NOT NULL THEN 1 
                        ELSE 2 
                    END,
                    orden ASC
                LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener todos los horarios vigentes (incluyendo especiales)
     */
    public function getHorariosVigentes() {
        $sql = "SELECT * FROM {$this->table} 
                WHERE activo = 1 
                AND (
                    (fecha_inicio IS NULL AND fecha_fin IS NULL) 
                    OR 
                    (CURDATE() BETWEEN fecha_inicio AND fecha_fin)
                )
                ORDER BY orden ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener horarios por tipo
     */
    public function getByTipo($tipo) {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} 
             WHERE tipo = :tipo AND activo = 1
             ORDER BY orden ASC"
        );
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verificar si un horario está vigente
     */
    public function estaVigente($id) {
        $horario = $this->getById($id);
        
        if (!$horario || !$horario['activo']) {
            return false;
        }

        // Si no tiene fechas, siempre está vigente
        if (!$horario['fecha_inicio'] || !$horario['fecha_fin']) {
            return true;
        }

        $hoy = date('Y-m-d');
        return ($hoy >= $horario['fecha_inicio'] && $hoy <= $horario['fecha_fin']);
    }

    /**
     * Formatear horario para mostrar
     */
    public function formatearHorario($horario) {
        if (!$horario) return null;

        return [
            'id' => $horario['id'],
            'tipo' => $horario['tipo'],
            'titulo' => $horario['titulo'],
            'descripcion' => $horario['descripcion'],
            'dias' => $horario['dias_semana'],
            'horario' => date('H:i', strtotime($horario['hora_inicio'])) . ' - ' . 
                        date('H:i', strtotime($horario['hora_fin'])),
            'hora_inicio' => $horario['hora_inicio'],
            'hora_fin' => $horario['hora_fin'],
            'observaciones' => $horario['observaciones'],
            'vigente' => $this->estaVigente($horario['id']),
            'periodo' => $this->getPeriodoVigencia($horario)
        ];
    }

    /**
     * Obtener periodo de vigencia legible
     */
    private function getPeriodoVigencia($horario) {
        if (!$horario['fecha_inicio'] || !$horario['fecha_fin']) {
            return 'Todo el año';
        }

        $inicio = date('d/m/Y', strtotime($horario['fecha_inicio']));
        $fin = date('d/m/Y', strtotime($horario['fecha_fin']));
        
        return "Desde {$inicio} hasta {$fin}";
    }

    /**
     * Obtener tipos de horario disponibles
     */
    public function getTipos() {
        return [
            'general' => 'Horario General',
            'verano' => 'Horario de Verano',
            'invierno' => 'Horario de Invierno',
            'especial' => 'Horario Especial'
        ];
    }

    /**
     * Validar que no haya conflictos de fechas
     */
    public function validarFechas($fecha_inicio, $fecha_fin, $excluir_id = null) {
        if (!$fecha_inicio || !$fecha_fin) {
            return true; // Horarios sin fechas son válidos
        }

        $sql = "SELECT COUNT(*) as count FROM {$this->table} 
                WHERE activo = 1 
                AND fecha_inicio IS NOT NULL 
                AND fecha_fin IS NOT NULL
                AND (
                    (fecha_inicio <= :fin AND fecha_fin >= :inicio)
                )";
        
        if ($excluir_id) {
            $sql .= " AND id != :excluir_id";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':inicio', $fecha_inicio);
        $stmt->bindParam(':fin', $fecha_fin);
        
        if ($excluir_id) {
            $stmt->bindParam(':excluir_id', $excluir_id);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] == 0;
    }
}