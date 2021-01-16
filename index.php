<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

session_start();
$controller = new \App\Http\Controllers\IndexController();

if (isset($_GET['action']) && !empty($_GET['action'])) {
    if (method_exists(new \App\Http\Controllers\IndexController(), $_GET['action'])) {
        $controller->{$_GET['action']}();
    } else {
        (new \App\Views\Errors\NotFoundView())->output();
    }

}
