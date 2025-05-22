<?php
namespace Controllers;

use Model\ActiveRecord;
use Model\Productos;
use Model\Categorias;
use Model\Prioridades;
use MVC\Router;

class ProductosController extends ActiveRecord { // ✅ Nombre corregido

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

    // ✅ Método corregido y renombrado
    public static function buscarAPI() {
        getHeadersApi();
        
        try {
            $productos = Productos::SQL("
                SELECT p.prod_id as id_producto, p.prod_nombre as nombre, p.prod_cantidad as cantidad, 
                       c.cat_nombre as categoria, pr.pri_nombre as prioridad, p.comprado,
                       p.cat_id as id_categoria, p.pri_id as id_prioridad
                FROM productos p 
                LEFT JOIN categorias c ON p.cat_id = c.cat_id 
                LEFT JOIN prioridades pr ON p.pri_id = pr.pri_id 
                ORDER BY p.prod_id DESC
            ");
            
            $data = [];
            foreach ($productos as $producto) {
                $data[] = [
                    'id_producto' => $producto->id_producto,
                    'nombre' => $producto->nombre,
                    'cantidad' => $producto->cantidad,
                    'categoria' => $producto->categoria ?? 'Sin categoría',
                    'prioridad' => $producto->prioridad ?? 'Sin prioridad',
                    'comprado' => $producto->comprado,
                    'id_categoria' => $producto->id_categoria,
                    'id_prioridad' => $producto->id_prioridad
                ];
            }
            
            echo json_encode([
                'tipo' => 'success',
                'mensaje' => 'Productos obtenidos correctamente',
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

    // ✅ Método agregado
    public static function modificarAPI() {
        getHeadersApi();
        
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id_producto'] ?? null;
                
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
                $id = $_POST['id_producto'] ?? null;
                
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

    public static function marcarCompradoAPI() {
        getHeadersApi();

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;
                $comprado = $_POST['comprado'] ?? 0;

                if (!$id) {
                    echo json_encode([
                        'codigo' => 0, 
                        'mensaje' => 'ID no proporcionado'
                    ]);
                    return;
                }

                $producto = Productos::find($id);

                if (!$producto) {
                    echo json_encode([
                        'codigo' => 0, 
                        'mensaje' => 'Producto no encontrado'
                    ]);
                    return;
                }

                $producto->comprado = $comprado;
                $resultado = $producto->guardar();

                if ($resultado['resultado']) {
                    $mensaje = $comprado == 1 ? 'Producto marcado como comprado' : 'Producto marcado como pendiente';
                    echo json_encode([
                        'codigo' => 1, 
                        'mensaje' => $mensaje
                    ]);
                } else {
                    echo json_encode([
                        'codigo' => 0, 
                        'mensaje' => 'Error al actualizar'
                    ]);
                }
            }
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0, 
                'mensaje' => 'Error del servidor: ' . $e->getMessage()
            ]);
        }
    }
}