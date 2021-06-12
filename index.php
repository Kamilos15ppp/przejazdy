<?php

declare(strict_types=1);

session_start();

spl_autoload_register(function (string $classNamespace) {
   $path = str_replace(['\\', 'App/'], ['/', ''], $classNamespace);
   $path = "src/$path.php";
   require_once($path);
});

require_once("src/Utils/debug.php");
$configuration = require_once("config/config.php");

use App\Controller\RideAbstractController;
use App\Controller\RideController;
use App\Exception\AppException;
use App\Exception\ConfigurationException;
use App\Request;

$request = new Request($_GET, $_POST, $_SERVER);

try {
    RideAbstractController::initConfiguration($configuration);
    (new RideController($request))->run();
} catch (ConfigurationException $e) {
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    echo 'Problem z aplikacją, proszę spróbować za chwilę.';
} catch (AppException $e) {
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    echo '<h3>' . $e->getMessage() . '</h3>';
} catch (Throwable $e) {
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    dump($e); //zakomentowac
}

