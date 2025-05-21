<?php 
require_once __DIR__ . '/../includes/app.php';

//--aqui se agrega los controladores

use MVC\Router;
use Controllers\AppController;
use Controllers\ProductosController;
use Controllers\CategoriaController;

//-----a
$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

//Aqui agrego las rutas
$router->get('/', [AppController::class,'index']);
$router->get('/productosMaria', [ProductosController::class,'renderizarPagina']);
$router->get('/CategoriaMaria', [CategoriaController::class,'renderizarPagina']);


//-------------------------------------------------------


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
