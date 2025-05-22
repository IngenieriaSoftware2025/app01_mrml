<?php 
require_once __DIR__ . '/../includes/app.php';

use Controllers\CategoriaController;
use MVC\Router;
use Controllers\AppController;
use Controllers\ProductoController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

// RUTAS DE CATEGORÍAS
$router->get('/categorias', [CategoriaController::class, 'renderizarPagina']);
$router->post('/categorias/guardarAPI', [CategoriaController::class, 'guardarAPI']);
$router->post('/categorias/obtenerAPI', [CategoriaController::class, 'obtenerAPI']);
$router->post('/categorias/actualizarAPI', [CategoriaController::class, 'actualizarAPI']);
$router->post('/categorias/eliminarAPI', [CategoriaController::class, 'eliminarAPI']);

// RUTAS DE PRODUCTOS
$router->get('/productos', [ProductoController::class, 'renderizarPagina']);
$router->post('/productos/guardarAPI', [ProductoController::class, 'guardarAPI']);
$router->post('/productos/obtenerAPI', [ProductoController::class, 'obtenerAPI']);
$router->post('/productos/actualizarAPI', [ProductoController::class, 'actualizarAPI']);
$router->post('/productos/eliminarAPI', [ProductoController::class, 'eliminarAPI']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();