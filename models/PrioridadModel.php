<?php

namespace Model;

namespace Model;

class Prioridad extends ActiveRecord {

    public static $tabla = 'prioridades';
    public static $columnasDB = [
        'id_prioridad',
        'nivel'
    ];

    public static $idTabla = 'id_prioridad';
    public $id_prioridad;
    public $nivel;

    public function __construct($args = []) {
        $this->id_prioridad = $args['id_prioridad'] ?? null;
        $this->nivel = $args['nivel'] ?? '';
    }
}