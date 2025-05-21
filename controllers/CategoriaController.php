<?php

namespace Controllers;

use MVC\Router;
//use Model\Clientes;
//Aqui se usa el modelo de active Record
use Model\ActiveRecord;


//Este extiende el ActiveRecord
class CategoriaController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        //aqui se pone la ruta donde esta
        $router->render('categoria/index', []);
    }
    
}