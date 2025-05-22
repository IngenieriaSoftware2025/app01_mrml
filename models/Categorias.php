<?php
// Archivo: Model/Categorias.php
namespace Model;

class Categorias extends ActiveRecord {
    public static $tabla = 'categorias';
    public static $columnasDB = [
        'id_categoria',  // ✅ Nombre real de la BD
        'nombre'         // ✅ Nombre real de la BD
    ];

    public static $idTabla = 'id_categoria';  // ✅ Nombre real de la BD
    public $id_categoria;  // ✅ Propiedad con nombre real
    public $nombre;        // ✅ Propiedad con nombre real

    public function __construct($args = []){
        $this->id_categoria = $args['id_categoria'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre de la categoría es obligatorio';
        }
        
        if(strlen($this->nombre) > 50) {
            self::$alertas['error'][] = 'El nombre de la categoría no puede tener más de 50 caracteres';
        }

        // Validar que no exista otra categoría con el mismo nombre
        if($this->nombre) {
            $existente = static::where('nombre', $this->nombre);
            if($existente && (empty($this->id_categoria) || $existente[0]->id_categoria != $this->id_categoria)) {
                self::$alertas['error'][] = 'Ya existe una categoría con ese nombre';
            }
        }

        return self::$alertas;
    }
}
