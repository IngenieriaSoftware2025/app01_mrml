<?php

//Inidico el tipo de archivo
namespace Model;

//Inidico como se llama mi tabla y las columnas que tiene
class Categorias extends ActiveRecord {
    //Es importante recalcar que estamos herendando todo de ActiveRecord

    public static $tabla = 'categorias';
    public static $columnasDB = [
        'id_categoria',          //  Nombre en la BD
        'nombre',        //  Nombre en la BD  Nombre en la BD
    ];

    //Declaramos las variables que vamos a usar
    public static $idTabla = 'id_categoria';  // El Id que esta en la tabla      
    public $id_categoria;
    public $nombre;

    public function __construct($args = []){
        $this->id_categoria = $args['id_producto'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }

}