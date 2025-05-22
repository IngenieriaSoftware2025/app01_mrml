<?php
namespace Controllers;

use Model\ActiveRecord;
use Model\Productos;
use Model\Categorias;
use Model\Prioridades;
use MVC\Router;

class ProductosController extends ActiveRecord {

    public static function renderizarPagina(Router $router) {
        // Obtener datos para los selects
        $categorias = Categorias::all();
        $prioridades = Prioridades::all();
        $productos = Productos::all();
        
        $router->render('productos/index', [
            'categorias' => $categorias,
            'prioridades' => $prioridades,
            'productos' => $productos
        ]);
    }

    public static function guardarAPI() {
        getHeadersApi();
        
        //Hago las validaciones, son importantes para que el usuario cumpla con todo

        //este lu se de base para cuando, es texto
        $_POST['nombre'] = htmlspecialchars($_POST['nombre']);
        if (empty($_POST['nombre'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del producto es obligatorio'
            ]);
            return;
        }

        //este lo uso de base para cuand oes numero
        $_POST['cantidad'] = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT);
        if ($_POST['cantidad'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad debe ser un número mayor a cero'
            ]);
            return;
        }

        $_POST['id_categoria'] = filter_var($_POST['id_categoria'], FILTER_VALIDATE_INT);
        if ($_POST['id_categoria'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debes seleccionar una categoría válida'
            ]);
            return;
        }

        $_POST['id_prioridad'] = filter_var($_POST['id_prioridad'], FILTER_VALIDATE_INT);
        if ($_POST['id_prioridad'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debes seleccionar una prioridad válida'
            ]);
            return;
        }

    }

}