<?php
namespace Controllers;

use Model\ActiveRecord;
use Model\Productos;
use Model\Categorias;
use Model\Prioridades;
use MVC\Router;

class ProductoController extends ActiveRecord {

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
        
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Crear nuevo producto
                $producto = new Productos($_POST);
                
                // Validar datos
                $alertas = $producto->validar();
                
                if (empty($alertas)) {
                    $resultado = $producto->guardar();
                    
                    if ($resultado['resultado']) {
                        echo json_encode([
                            'tipo' => 'success',
                            'mensaje' => 'Producto guardado correctamente',
                            'codigo' => 1,
                            'data' => $resultado
                        ]);
                    } else {
                        echo json_encode([
                            'tipo' => 'error',
                            'mensaje' => 'Error al guardar el producto',
                            'codigo' => 0
                        ]);
                    }
                } else {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => 'Datos inválidos',
                        'alertas' => $alertas,
                        'codigo' => 0
                    ]);
                }
            }
        } catch (Exception $e) {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => 'Error del servidor: ' . $e->getMessage(),
                'codigo' => 0
            ]);
        }
    }

    public static function obtenerAPI() {
        getHeadersApi();
        
        try {
            $productos = Productos::SQL("
                SELECT p.*, c.cat_nombre, pr.pri_nombre 
                FROM productos p 
                LEFT JOIN categorias c ON p.cat_id = c.cat_id 
                LEFT JOIN prioridades pr ON p.pri_id = pr.pri_id 
                ORDER BY p.prod_id DESC
            ");
            
            $data = [];
            foreach ($productos as $producto) {
                $data[] = [
                    'prod_id' => $producto->prod_id,
                    'prod_nombre' => $producto->prod_nombre,
                    'prod_cantidad' => $producto->prod_cantidad,
                    'cat_nombre' => $producto->cat_nombre ?? 'Sin categoría',
                    'pri_nombre' => $producto->pri_nombre ?? 'Sin prioridad',
                    'comprado' => $producto->comprado ? 'Sí' : 'No',
                    'cat_id' => $producto->cat_id,
                    'pri_id' => $producto->pri_id
                ];
            }
            
            echo json_encode([
                'tipo' => 'success',
                'data' => $data,
                'codigo' => 1
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => 'Error al obtener productos: ' . $e->getMessage(),
                'codigo' => 0
            ]);
        }
    }

    public static function actualizarAPI() {
        getHeadersApi();
        
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['prod_id'] ?? null;
                
                if (!$id) {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => 'ID de producto requerido',
                        'codigo' => 0
                    ]);
                    return;
                }
                
                $producto = Productos::find($id);
                
                if (!$producto) {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => 'Producto no encontrado',
                        'codigo' => 0
                    ]);
                    return;
                }
                
                // Sincronizar con nuevos datos
                $producto->sincronizar($_POST);
                
                $alertas = $producto->validar();
                
                if (empty($alertas)) {
                    $resultado = $producto->guardar();
                    
                    if ($resultado['resultado']) {
                        echo json_encode([
                            'tipo' => 'success',
                            'mensaje' => 'Producto actualizado correctamente',
                            'codigo' => 1
                        ]);
                    } else {
                        echo json_encode([
                            'tipo' => 'error',
                            'mensaje' => 'Error al actualizar el producto',
                            'codigo' => 0
                        ]);
                    }
                } else {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => 'Datos inválidos',
                        'alertas' => $alertas,
                        'codigo' => 0
                    ]);
                }
            }
        } catch (Exception $e) {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => 'Error del servidor: ' . $e->getMessage(),
                'codigo' => 0
            ]);
        }
    }

    public static function eliminarAPI() {
        getHeadersApi();
        
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['prod_id'] ?? null;
                
                if (!$id) {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => 'ID de producto requerido',
                        'codigo' => 0
                    ]);
                    return;
                }
                
                $producto = Productos::find($id);
                
                if (!$producto) {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => 'Producto no encontrado',
                        'codigo' => 0
                    ]);
                    return;
                }
                
                $resultado = $producto->eliminar();
                
                if ($resultado) {
                    echo json_encode([
                        'tipo' => 'success',
                        'mensaje' => 'Producto eliminado correctamente',
                        'codigo' => 1
                    ]);
                } else {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => 'Error al eliminar el producto',
                        'codigo' => 0
                    ]);
                }
            }
        } catch (Exception $e) {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => 'Error del servidor: ' . $e->getMessage(),
                'codigo' => 0
            ]);
        }
    }

    public static function marcarCompradoAPI()
{
    header('Content-Type: application/json; charset=utf-8');

    $id = $_POST['id'] ?? null;
    $comprado = $_POST['comprado'] ?? 0;

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

        $producto->sincronizar(['comprado' => $comprado]);
        $producto->actualizar();

        $mensaje = $comprado == 1 ? 'Producto marcado como comprado' : 'Producto marcado como pendiente';
        
        http_response_code(200);
        echo json_encode(['codigo' => 1, 'mensaje' => $mensaje]);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['codigo' => 0, 'mensaje' => 'Error al actualizar', 'detalle' => $e->getMessage()]);
    }
}
}