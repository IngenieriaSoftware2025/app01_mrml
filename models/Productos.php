<?php
namespace Model;

class Productos extends ActiveRecord {
    public static $tabla = 'productos';
    public static $columnasDB = [
        'id_producto',     // ✅ Nombre real de la BD
        'nombre',          // ✅ Nombre real de la BD
        'cantidad',        // ✅ Nombre real de la BD
        'id_categoria',    // ✅ Nombre real de la BD
        'id_prioridad',    // ✅ Nombre real de la BD
        'notas_adicionales', // ✅ Nombre real de la BD
        'comprado'         // ✅ Nombre real de la BD
    ];

    public static $idTabla = 'id_producto';  // ✅ Nombre real de la BD
    public $id_producto;      // ✅ Propiedades con nombres reales
    public $nombre;
    public $cantidad;
    public $id_categoria;
    public $id_prioridad;
    public $notas_adicionales;
    public $comprado;

    public function __construct($args = []){
        $this->id_producto = $args['id_producto'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->cantidad = $args['cantidad'] ?? 1;
        $this->id_categoria = $args['id_categoria'] ?? null;
        $this->id_prioridad = $args['id_prioridad'] ?? null;
        $this->notas_adicionales = $args['notas_adicionales'] ?? '';
        $this->comprado = $args['comprado'] ?? 0;
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del producto es obligatorio';
        }
        
        if(strlen($this->nombre) > 100) {
            self::$alertas['error'][] = 'El nombre del producto no puede tener más de 100 caracteres';
        }

        if(!$this->cantidad || $this->cantidad < 1) {
            self::$alertas['error'][] = 'La cantidad debe ser mayor a 0';
        }

        if(!$this->id_categoria) {
            self::$alertas['error'][] = 'La categoría es obligatoria';
        }

        if(!$this->id_prioridad) {
            self::$alertas['error'][] = 'La prioridad es obligatoria';
        }

        // Validar que la categoría existe
        if($this->id_categoria) {
            $categoria = Categorias::find($this->id_categoria);
            if(!$categoria) {
                self::$alertas['error'][] = 'La categoría seleccionada no existe';
            }
        }

        // Validar que la prioridad existe
        if($this->id_prioridad) {
            $prioridad = Prioridades::find($this->id_prioridad);
            if(!$prioridad) {
                self::$alertas['error'][] = 'La prioridad seleccionada no existe';
            }
        }

        return self::$alertas;
    }
}