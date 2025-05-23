<?php

namespace Controllers;

use Exception;
use Model\Productos;
use Model\Categorias;
use Model\Prioridades;
use MVC\Router;

class ProductosController {

    public static function renderizarPagina(Router $router) {
        $categorias = Categorias::all();
        $prioridades = Prioridades::all();

        $router->render('productos/index', [
            'categorias' => $categorias,
            'prioridades' => $prioridades
        ]);
    }

    public static function guardarAPI() {
        getHeadersApi();

        $_POST['nombre'] = htmlspecialchars($_POST['nombre'] ?? '');

        if (empty($_POST['nombre'])) {
            http_response_code(400);
            echo json_encode(['codigo' => 0, 'mensaje' => 'El nombre del producto es obligatorio']);
            return;
        }

        $_POST['cantidad'] = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT);
        $_POST['id_categoria'] = filter_var($_POST['id_categoria'], FILTER_VALIDATE_INT);
        $_POST['id_prioridad'] = filter_var($_POST['id_prioridad'], FILTER_VALIDATE_INT);

        if ($_POST['cantidad'] <= 0 || $_POST['id_categoria'] <= 0 || $_POST['id_prioridad'] <= 0) {
            http_response_code(400);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Datos inválidos']);
            return;
        }

        try {
            $sql = "SELECT * FROM productos WHERE nombre = '" . $_POST['nombre'] . "' AND id_categoria = " . $_POST['id_categoria'] . " AND situacion = 1";
            $existente = Productos::fetchArray($sql);

            if (!empty($existente)) {
                http_response_code(400);
                echo json_encode(['codigo' => 0, 'mensaje' => 'Ya existe este producto en esta categoría']);
                return;
            }

            $producto = new Productos([
                'nombre' => $_POST['nombre'],
                'cantidad' => $_POST['cantidad'],
                'id_categoria' => $_POST['id_categoria'],
                'id_prioridad' => $_POST['id_prioridad'],
                'notas_adicionales' => $_POST['notas_adicionales'] ?? '',
                'situacion_comprado' => 0,
                'situacion' => 1
            ]);

            $producto->guardar();

            http_response_code(200);
            echo json_encode(['codigo' => 1, 'mensaje' => 'Producto guardado exitosamente']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Error al guardar', 'detalle' => $e->getMessage()]);
        }
    }

    public static function buscarAPI() {
        header('Content-Type: application/json');

        try {
            $sql = "
                SELECT 
                    p.id_producto,
                    p.nombre,
                    p.cantidad,
                    p.notas_adicionales,
                    p.situacion_comprado,
                    c.nombre AS categoria_nombre,
                    pr.nivel AS prioridad_nombre,
                    p.id_categoria,
                    p.id_prioridad
                FROM productos p
                JOIN categorias c ON p.id_categoria = c.id_categoria
                JOIN prioridades pr ON p.id_prioridad = pr.id_prioridad
                WHERE p.situacion = 1
                ORDER BY p.situacion_comprado ASC, c.nombre ASC, pr.id_prioridad ASC
            ";

            $productos = Productos::fetchArray($sql);

            echo json_encode(['codigo' => 1, 'mensaje' => 'Productos obtenidos correctamente', 'data' => $productos]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Error al obtener', 'detalle' => $e->getMessage()]);
        }
    }

    public static function modificarAPI() {
        getHeadersApi();

        $id = $_POST['id_producto'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['codigo' => 0, 'mensaje' => 'ID no proporcionado']);
            return;
        }

        $_POST['nombre'] = htmlspecialchars($_POST['nombre'] ?? '');
        $_POST['cantidad'] = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT);
        $_POST['id_categoria'] = filter_var($_POST['id_categoria'], FILTER_VALIDATE_INT);
        $_POST['id_prioridad'] = filter_var($_POST['id_prioridad'], FILTER_VALIDATE_INT);

        try {
            $producto = Productos::find($id);

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
                'notas_adicionales' => $_POST['notas_adicionales'] ?? ''
            ]);

            $producto->guardar();

            http_response_code(200);
            echo json_encode(['codigo' => 1, 'mensaje' => 'Producto actualizado correctamente']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Error al modificar', 'detalle' => $e->getMessage()]);
        }
    }

    public static function cambiarEstadoAPI() {
        getHeadersApi();

        $id = $_POST['id_producto'] ?? null;
        $estado = isset($_POST['situacion_comprado']) ? (int)$_POST['situacion_comprado'] : null;

        if (!$id || $estado === null) {
            http_response_code(400);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Datos incompletos']);
            return;
        }

        try {
            $producto = Productos::find($id);

            if (!$producto) {
                http_response_code(404);
                echo json_encode(['codigo' => 0, 'mensaje' => 'Producto no encontrado']);
                return;
            }

            $producto->sincronizar(['situacion_comprado' => $estado]);
            $producto->guardar();

            http_response_code(200);
            echo json_encode(['codigo' => 1, 'mensaje' => 'Estado actualizado']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Error al cambiar estado', 'detalle' => $e->getMessage()]);
        }
    }

    public static function eliminarAPI() {
        getHeadersApi();

        $id = $_POST['id_producto'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['codigo' => 0, 'mensaje' => 'ID no proporcionado']);
            return;
        }

        try {
            $producto = Productos::find($id);

            if (!$producto) {
                http_response_code(404);
                echo json_encode(['codigo' => 0, 'mensaje' => 'Producto no encontrado']);
                return;
            }

            $producto->sincronizar(['situacion' => 0]);
            $producto->guardar();

            http_response_code(200);
            echo json_encode(['codigo' => 1, 'mensaje' => 'Producto eliminado correctamente']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Error al eliminar', 'detalle' => $e->getMessage()]);
        }
    }
}
