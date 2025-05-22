<?php
namespace Controllers;

use Model\ActiveRecord;
use Model\Categorias;
use MVC\Router;

class CategoriaController extends ActiveRecord {
    
    public static function renderizarPagina(Router $router) {
        $categorias = Categorias::all();
        
        $router->render('categorias/index', [
            'categorias' => $categorias
        ]);
    }
    
    public static function guardarAPI() {
        getHeadersApi();
        
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $categoria = new Categorias($_POST);
                
                // Validar datos
                $alertas = $categoria->validar();
                
                if (empty($alertas)) {
                    $resultado = $categoria->guardar();
                    
                    if ($resultado['resultado']) {
                        echo json_encode([
                            'tipo' => 'success',
                            'mensaje' => 'Categoría guardada correctamente',
                            'codigo' => 1,
                            'data' => $resultado
                        ]);
                    } else {
                        echo json_encode([
                            'tipo' => 'error',
                            'mensaje' => 'Error al guardar la categoría',
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
            $categorias = Categorias::all();
            
            echo json_encode([
                'tipo' => 'success',
                'data' => $categorias,
                'codigo' => 1
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'tipo' => 'error',
                'mensaje' => 'Error al obtener categorías: ' . $e->getMessage(),
                'codigo' => 0
            ]);
        }
    }

    public static function actualizarAPI() {
        getHeadersApi();
        
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['cat_id'] ?? null;
                
                if (!$id) {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => 'ID de categoría requerido',
                        'codigo' => 0
                    ]);
                    return;
                }
                
                $categoria = Categorias::find($id);
                
                if (!$categoria) {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => 'Categoría no encontrada',
                        'codigo' => 0
                    ]);
                    return;
                }
                
                $categoria->sincronizar($_POST);
                
                $alertas = $categoria->validar();
                
                if (empty($alertas)) {
                    $resultado = $categoria->guardar();
                    
                    if ($resultado['resultado']) {
                        echo json_encode([
                            'tipo' => 'success',
                            'mensaje' => 'Categoría actualizada correctamente',
                            'codigo' => 1
                        ]);
                    } else {
                        echo json_encode([
                            'tipo' => 'error',
                            'mensaje' => 'Error al actualizar la categoría',
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
                $id = $_POST['cat_id'] ?? null;
                
                if (!$id) {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => 'ID de categoría requerido',
                        'codigo' => 0
                    ]);
                    return;
                }
                
                $categoria = Categorias::find($id);
                
                if (!$categoria) {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => 'Categoría no encontrada',
                        'codigo' => 0
                    ]);
                    return;
                }
                
                $resultado = $categoria->eliminar();
                
                if ($resultado) {
                    echo json_encode([
                        'tipo' => 'success',
                        'mensaje' => 'Categoría eliminada correctamente',
                        'codigo' => 1
                    ]);
                } else {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => 'Error al eliminar la categoría',
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
}