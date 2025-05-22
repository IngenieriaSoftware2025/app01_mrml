<?php

namespace Controllers;

use MVC\Router;
use Model\Categoria;
use Model\Prioridad;
use Model\Producto;
use Exception;

class ProductosController
{
    // Muestra la vista principal con categorías y prioridades
    public static function renderizarPagina(Router $router)
    {
        $categorias = Categoria::all();
        $prioridades = Prioridad::all();

        $router->render('productos/index', [
            'categorias' => $categorias,
            'prioridades' => $prioridades
        ]);
    }

    // Guarda un nuevo producto en la base de datos
    public static function guardarAPI()
    {
        header('Content-Type: application/json; charset=utf-8');

        // Validar campos
        if(empty($_POST['nombre'])) {
            http_response_code(400);
            echo json_encode(['codigo' => 0, 'mensaje' => 'El nombre del producto es obligatorio']);
            return;
        }

        $_POST['cantidad'] = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT);
        if(!$_POST['cantidad'] || $_POST['cantidad'] <= 0) {
            http_response_code(400);
            echo json_encode(['codigo' => 0, 'mensaje' => 'La cantidad debe ser un número positivo']);
            return;
        }

        $_POST['id_categoria'] = filter_var($_POST['id_categoria'], FILTER_VALIDATE_INT);
        if(!$_POST['id_categoria']) {
            http_response_code(400);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Selecciona una categoría válida']);
            return;
        }

        $_POST['id_prioridad'] = filter_var($_POST['id_prioridad'], FILTER_VALIDATE_INT);
        if(!$_POST['id_prioridad']) {
            http_response_code(400);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Selecciona una prioridad válida']);
            return;
        }

        try {
            $producto = new Producto([
                'nombre' => $_POST['nombre'],
                'cantidad' => $_POST['cantidad'],
                'id_categoria' => $_POST['id_categoria'],
                'id_prioridad' => $_POST['id_prioridad'],
                'notas_adicionales' => $_POST['notas_adicionales'] ?? null,
                'comprado' => 0
            ]);

            $producto->crear();

            http_response_code(200);
            echo json_encode(['codigo' => 1, 'mensaje' => 'Producto guardado exitosamente']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Error al guardar', 'detalle' => $e->getMessage()]);
        }
    }

    // Muestra todos los productos con JOIN a categoría y prioridad
    public static function buscarAPI()
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            $sql = "
                SELECT 
                    p.id_producto,
                    p.nombre,
                    p.cantidad,
                    p.notas_adicionales,
                    p.comprado,
                    c.nombre AS categoria,
                    pr.nivel AS prioridad
                FROM productos p
                JOIN categorias c ON p.id_categoria = c.id_categoria
                JOIN prioridades pr ON p.id_prioridad = pr.id_prioridad
                ORDER BY p.comprado ASC, c.nombre ASC, pr.id_prioridad ASC
            ";

            $data = Producto::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Productos obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los productos',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public static function modificarAPI()
    {
    header('Content-Type: application/json; charset=utf-8');

    $id = $_POST['id_producto'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(['codigo' => 0, 'mensaje' => 'ID de producto no proporcionado']);
        return;
    }

    // Validaciones como en guardar
    if (empty($_POST['nombre'])) {
        http_response_code(400);
        echo json_encode(['codigo' => 0, 'mensaje' => 'El nombre es obligatorio']);
        return;
    }

    $_POST['cantidad'] = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT);
    if (!$_POST['cantidad'] || $_POST['cantidad'] <= 0) {
        http_response_code(400);
        echo json_encode(['codigo' => 0, 'mensaje' => 'Cantidad inválida']);
        return;
    }

    $_POST['id_categoria'] = filter_var($_POST['id_categoria'], FILTER_VALIDATE_INT);
    $_POST['id_prioridad'] = filter_var($_POST['id_prioridad'], FILTER_VALIDATE_INT);

    try {
        $producto = Producto::find($id);

        if (!$producto) {
            http_response_code(404);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Producto no encontrado']);
            return;
        }

        $producto->sincronizar([
            'nombre' => $_POST['nombre'],
            'cantidad' => $_POST['cantidad'],
            'id_categoria' => $_POST['id_categoria'],
            'id_prioridad' => $_POST['id_prioridad'],
            'notas_adicionales' => $_POST['notas_adicionales'] ?? null,
            'comprado' => $_POST['comprado'] ?? 0
        ]);

        $producto->actualizar();

        http_response_code(200);
        echo json_encode(['codigo' => 1, 'mensaje' => 'Producto actualizado correctamente']);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['codigo' => 0, 'mensaje' => 'Error al actualizar', 'detalle' => $e->getMessage()]);
        }
    }
public static function eliminarAPI()
    {
    header('Content-Type: application/json; charset=utf-8');

    $id = $_POST['id_producto'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(['codigo' => 0, 'mensaje' => 'ID no proporcionado']);
        return;
    }

    try {
        $producto = Producto::find($id);

        if (!$producto) {
            http_response_code(404);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Producto no encontrado']);
            return;
        }

        $producto->eliminar();

        http_response_code(200);
        echo json_encode(['codigo' => 1, 'mensaje' => 'Producto eliminado correctamente']);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['codigo' => 0, 'mensaje' => 'Error al eliminar', 'detalle' => $e->getMessage()]);
    }
    }

}
