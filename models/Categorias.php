<?php

namespace Model;

class Categorias extends ActiveRecord {
    public static $tabla = 'categorias';
    public static $columnasDB = [
        'cat_nombre'
    ];

    public static $idTabla = 'cat_id';
    public $cat_id;
    public $cat_nombre;

    public function __construct($args = []){
        $this->cat_id = $args['cat_id'] ?? null;
        $this->cat_nombre = $args['cat_nombre'] ?? '';
    }

    public function validar() {
        if(!$this->cat_nombre) {
            self::$alertas['error'][] = 'El nombre de la categoría es obligatorio';
        }
        
        if(strlen($this->cat_nombre) > 50) {
            self::$alertas['error'][] = 'El nombre de la categoría no puede tener más de 50 caracteres';
        }

        // Validar que no exista otra categoría con el mismo nombre
        if($this->cat_nombre) {
            $existente = static::where('cat_nombre', $this->cat_nombre);
            if($existente && (empty($this->cat_id) || $existente[0]->cat_id != $this->cat_id)) {
                self::$alertas['error'][] = 'Ya existe una categoría con ese nombre';
            }
        } // ← Esta llave faltaba

        return self::$alertas;
    }
}