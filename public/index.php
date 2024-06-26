<?php
require_once __DIR__ .  '/../vendor/autoload.php';
use App\Routes\RouteManager;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$routeManager = new RouteManager();
$routeManager->run();

