<?php 
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\ProductosController;


$router = new Router();

// Si usás subcarpeta, esto se queda. Si estás en la raíz, podés comentarlo
$router->setBaseURL('/' . $_ENV['APP_NAME']);

// Rutas principales
$router->get('/', [AppController::class, 'index']);

// Vistas
$router->get('/productos', [ProductosController::class, 'renderizarPagina']);

// Productos - API
$router->post('/productos/guardarAPI', [ProductosController::class, 'guardarAPI']);
$router->post('/productos/buscarAPI', [ProductosController::class, 'buscarAPI']);
$router->post('/productos/modificarAPI', [ProductosController::class, 'modificarAPI']);
$router->post('/productos/eliminarAPI', [ProductosController::class, 'eliminarAPI']);
$router->post('/productos/cambiarEstadoAPI', [ProductosController::class, 'cambiarEstadoAPI']);

// Si querés permitir GET para buscar
$router->get('/productos/buscarAPI', [ProductosController::class, 'buscarAPI']);

// Confirmar rutas
$router->comprobarRutas();
