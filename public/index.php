<?php

require_once '../vendor/autoload.php';

use Slimvc\FrontController;

$app = new \Slim\Slim();

$fc = (new FrontController($app, require_once('../config/bootstrap.php')))->init();
