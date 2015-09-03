<?php

define('APP_PATH', dirname(__FILE__));
define('APP_NAME', 'Sample');

use JWT\JWT;
use CBase\Query\Query;

$libConfig = [
  'pdo'   => new PDO('mysql:host=127.0.0.1;dbname=dbname', 'dbuser', 'dbpassword'),
  'apikey'=> 'secret'
];

$jwt = new JWT();
$jwt->setIssuer('http://localhost')
    ->setAudience('http://localhost')
    ->setIssuedAt(time())
    ->sign($libConfig['apikey'])
    ->getToken();

$db = new Query($libConfig);

return [
    'db'     => $db,
    'jwt'    => $jwt,
    'apikey' => &$libConfig['apikey']
];
