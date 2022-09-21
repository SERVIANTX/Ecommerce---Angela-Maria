<?php

    /*=============================================
        TODO: Zona Horaria
    =============================================*/

    date_default_timezone_set('America/Lima');

    /*=============================================
        TODO: Mostrar errores
    =============================================*/

    ini_set('display_errors', 1);
    ini_set("log_errors", 1);
    ini_set("error_log",  "D:/xampp/htdocs/Proyecto_modular/angelamaria/php_error_log");

    /*=============================================
        TODO: CORS
    =============================================*/

    /* TODO: Permitir el acceso de otro origen */

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: POST');

    /*=============================================
        TODO: Requerimientos
    =============================================*/

    require_once "controllers/template.controller.php";
    require_once "controllers/curl.controller.php";
    require_once "controllers/users.controller.php";
    require_once "controllers/subscribers.controller.php";
    require "extensions/vendor/autoload.php";

    $index = new TemplateController();
    $index -> index();

?>