<?php

namespace Model;

namespace Model;

class Producto extends ActiveRecord {

    public static $tabla = 'productos';
    public static $columnasDB = [
        'id_producto',
        'nombre',
        'cantidad',
        'id_categoria',
        'id_prioridad',
        'notas_adicionales',
        'comprado'
    ];

    public static $idTabla = 'id_producto';

    public $id_producto;
    public $nombre;
    public $cantidad;
    public $id_categoria;
    public $id_prioridad;
    public $notas_adicionales;
    public $comprado;

    public function __construct($args = []) {
        $this->id_producto = $args['id_producto'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->cantidad = $args['cantidad'] ?? 1;
        $this->id_categoria = $args['id_categoria'] ?? null;
        $this->id_prioridad = $args['id_prioridad'] ?? null;
        $this->notas_adicionales = $args['notas_adicionales'] ?? null;
        $this->comprado = $args['comprado'] ?? 0;
    }
}