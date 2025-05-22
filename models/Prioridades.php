<?php

namespace Model;

class Prioridades extends ActiveRecord {
    public static $tabla = 'prioridades';
    public static $columnasDB = [
        'id_prioridad',  //Nombre real de la BD
        'nivel'          //Nombre real de la BD
    ];

    public static $idTabla = 'id_prioridad';  //Nombre real de la BD
    public $id_prioridad;
    public $nivel;  

    public function __construct($args = []) {
        $this->id_prioridad = $args['id_prioridad'] ?? null;
        $this->nivel = $args['nivel'] ?? '';
    }
}