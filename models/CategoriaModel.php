<?php

namespace Model;

namespace Model;

class Categoria extends ActiveRecord {

    public static $tabla = 'categorias';
    public static $columnasDB = [
        'id_categoria',
        'nombre'
    ];

    public static $idTabla = 'id_categoria';
    public $id_categoria;
    public $nombre;

    public function __construct($args = []) {
        $this->id_categoria = $args['id_categoria'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }
}
