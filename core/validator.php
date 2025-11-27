<?php
// core/Validator.php
class Validator {
    
    private $errors = [];
    private $data = [];
    
    public function __construct($data) {
        $this->data = $data;
    }
    
    // Validar campo requerido
    public function required($field, $message = null) {
        if(!isset($this->data[$field]) || trim($this->data[$field]) === '') {
            $this->errors[$field][] = $message ?? "El campo {$field} es obligatorio";
        }
        return $this;
    }
    
    // Validar email
    public function email($field, $message = null) {
        if(isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = $message ?? "El campo {$field} debe ser un email válido";
        }
        return $this;
    }
    
    // Validar longitud mínima
    public function min($field, $length, $message = null) {
        if(isset($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->errors[$field][] = $message ?? "El campo {$field} debe tener al menos {$length} caracteres";
        }
        return $this;
    }
    
    // Validar longitud máxima
    public function max($field, $length, $message = null) {
        if(isset($this->data[$field]) && strlen($this->data[$field]) > $length) {
            $this->errors[$field][] = $message ?? "El campo {$field} no puede exceder {$length} caracteres";
        }
        return $this;
    }
    
    // Validar número
    public function numeric($field, $message = null) {
        if(isset($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->errors[$field][] = $message ?? "El campo {$field} debe ser numérico";
        }
        return $this;
    }
    
    // Validar que coincidan dos campos
    public function match($field, $matchField, $message = null) {
        if(isset($this->data[$field]) && isset($this->data[$matchField]) && 
           $this->data[$field] !== $this->data[$matchField]) {
            $this->errors[$field][] = $message ?? "Los campos {$field} y {$matchField} no coinciden";
        }
        return $this;
    }
    
    // Validar valor único en BD
    public function unique($field, $table, $column, $excludeId = null, $message = null) {
        if(!isset($this->data[$field])) return $this;
        
        $db = (new Database())->connect();
        
        $sql = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = :value";
        if($excludeId) {
            $sql .= " AND id != :excludeId";
        }
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':value', $this->data[$field]);
        if($excludeId) {
            $stmt->bindValue(':excludeId', $excludeId);
        }
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($result['count'] > 0) {
            $this->errors[$field][] = $message ?? "El valor de {$field} ya está en uso";
        }
        
        return $this;
    }
    
    // Validar formato de fecha
    public function date($field, $format = 'Y-m-d', $message = null) {
        if(isset($this->data[$field])) {
            $d = DateTime::createFromFormat($format, $this->data[$field]);
            if(!$d || $d->format($format) !== $this->data[$field]) {
                $this->errors[$field][] = $message ?? "El campo {$field} no tiene un formato de fecha válido";
            }
        }
        return $this;
    }
    
    // Validar URL
    public function url($field, $message = null) {
        if(isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_URL)) {
            $this->errors[$field][] = $message ?? "El campo {$field} debe ser una URL válida";
        }
        return $this;
    }
    
    // Validar que el campo esté en una lista de valores
    public function in($field, $values, $message = null) {
        if(isset($this->data[$field]) && !in_array($this->data[$field], $values)) {
            $this->errors[$field][] = $message ?? "El valor de {$field} no es válido";
        }
        return $this;
    }
    
    // Validar patrón regex
    public function pattern($field, $pattern, $message = null) {
        if(isset($this->data[$field]) && !preg_match($pattern, $this->data[$field])) {
            $this->errors[$field][] = $message ?? "El formato de {$field} no es válido";
        }
        return $this;
    }
    
    // Validar archivo subido
    public function file($field, $maxSize = null, $allowedTypes = [], $message = null) {
        if(!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
            return $this;
        }
        
        if($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            $this->errors[$field][] = $message ?? "Error al subir el archivo {$field}";
            return $this;
        }
        
        // Validar tamaño
        if($maxSize && $_FILES[$field]['size'] > $maxSize) {
            $maxMB = $maxSize / 1048576;
            $this->errors[$field][] = "El archivo {$field} no debe exceder {$maxMB}MB";
        }
        
        // Validar tipo
        if(!empty($allowedTypes)) {
            $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
            if(!in_array($ext, $allowedTypes)) {
                $this->errors[$field][] = "El tipo de archivo {$field} no es válido. Permitidos: " . implode(', ', $allowedTypes);
            }
        }
        
        return $this;
    }
    
    // Verificar si hay errores
    public function fails() {
        return !empty($this->errors);
    }
    
    // Obtener todos los errores
    public function errors() {
        return $this->errors;
    }
    
    // Obtener primer error
    public function firstError($field = null) {
        if($field) {
            return $this->errors[$field][0] ?? null;
        }
        
        foreach($this->errors as $fieldErrors) {
            return $fieldErrors[0];
        }
        
        return null;
    }
    
    // Obtener datos validados (sanitizados)
    public function validated() {
        $validated = [];
        foreach($this->data as $key => $value) {
            if(!isset($this->errors[$key])) {
                $validated[$key] = htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
            }
        }
        return $validated;
    }
}