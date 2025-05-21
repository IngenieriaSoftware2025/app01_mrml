<?php 
require_once __DIR__ . '/../includes/app.php';

//--aqui se agreega cada vez que hacemos una pagina

use MVC\Router;
use Controllers\AppController;
use Controllers\ProductosControlador;


//-----a
$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

//Aqui agrego las rutas

$router->get('/', [AppController::class,'index']);
$router->get('/productos_de_maria', [ProductosControlador::class,'renderizarPagina']);


//-------------------------------------------------------


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
