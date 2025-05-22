<?php

//Inidico el tipo de archivo
namespace Model;

//Inidico como se llama mi tabla y las columnas que tiene
class Productos extends ActiveRecord {
    //Es importante recalcar que estamos herendando todo de ActiveRecord

    public static $tabla = 'productos';
    public static $columnasDB = [
        'nombre',          //  Nombre en la BD
        'cantidad',        //  Nombre en la BD
        'id_categoria',    //  Nombre en la BD
        'id_prioridad',    //  Nombre en la BD
        'notas_adicionales',//  Nombre en la BD 
        'situacion_comprado',//  Nombre en la BD
        'situacion'//  Nombre en la BD
    ];

    //Declaramos las variables que vamos a usar
    public static $idTabla = 'id_producto';  // El Id que esta en la tabla      
    public $id_producto;
    public $nombre;
    public $cantidad;
    public $id_categoria;
    public $id_prioridad;
    public $notas_adicionales;
    public $situacion_comprado;
    public $situacion;

    //hago un constructor e indico como vienen los productos, si no vienen le digo quer valor
    public function __construct($args = []){
        $this->id_producto = $args['id_producto'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->cantidad = $args['cantidad'] ?? 1;
        $this->id_categoria = $args['id_categoria'] ?? null;
        $this->id_prioridad = $args['id_prioridad'] ?? null;
        $this->notas_adicionales = $args['notas_adicionales'] ?? '';
        $this->situacion_comprado = $args['situacion_comprado'] ?? 0;
        $this->situacion = $args['situacion'] ?? 1;
    }

}