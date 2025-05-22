<?php 
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\ProductosController;
use Controllers\CategoriaController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

// Rutas GET
$router->get('/', [AppController::class,'index']);
$router->get('/productosMaria', [ProductosController::class,'renderizarPagina']);
$router->get('/CategoriaMaria', [CategoriaController::class,'renderizarPagina']);

// Rutas POST para las APIs
$router->post('/productos/guardarAPI', [ProductosController::class,'guardarAPI']);
$router->post('/productos/buscarAPI', [ProductosController::class,'buscarAPI']);
$router->post('/productos/modificarAPI', [ProductosController::class,'modificarAPI']);
$router->post('/productos/eliminarAPI', [ProductosController::class,'eliminarAPI']);
$router->post('/productos/marcarCompradoAPI', [ProductosController::class,'marcarCompradoAPI']);

// También agrega la ruta GET para buscar (por si acaso)
$router->get('/productos/buscarAPI', [ProductosController::class,'buscarAPI']);

$router->comprobarRutas();