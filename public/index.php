<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include __DIR__ . "/../vendor/autoload.php";

$obj = new App\Classes\Router;
$obj->run();