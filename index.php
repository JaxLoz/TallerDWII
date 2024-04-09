<?php

use controller\EventController;

require "controller/EventController.php";
require "controller/TeamController.php";
require "controller/AthleteController.php";
require "controller/ParticipationController.php";
$routes = [

    "event" => "\\controller\\EventController",
    "team" => "\\controller\\TeamController",
    "athlete" => "\\controller\\AthleteController",
    "participation" => "\\controller\\ParticipationController"

];

$requestUri = $_SERVER['REQUEST_URI'];
$pathInfo = parse_url($requestUri, PHP_URL_PATH);
$regex = "/\/(?P<controller>\w+)\/(?P<action>\w+)\/?(?P<id>\d+)?/";
preg_match($regex, $pathInfo, $pathMatches);

$nameController = isset($pathMatches["controller"]) ? $pathMatches["controller"] : "";
$action = isset($pathMatches["action"]) ? $pathMatches["action"] : "";

if(isset($routes[$nameController])){

    $controllerInstance = new $routes[$nameController]();

    $httpMethod = $_SERVER["REQUEST_METHOD"];
    $nameMethod = $action . ucfirst(strtolower($httpMethod));

    if(method_exists($controllerInstance, $nameMethod)){

        if(isset($pathMatches["id"])){
            $controllerInstance->$nameMethod($pathMatches["id"]);
        }else{
            $controllerInstance->$nameMethod();
        }
    }else{
        echo "Metodo no encontrado";
    }

}


