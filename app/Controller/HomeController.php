<?php

namespace Sample\Controller;

use Slimvc\Controller;

/**
* HomeController
*/
class HomeController extends Controller
{
    public static $actions = [
        '/index/:name' => 'index',
        '/index'       => 'index',
        '/'            => 'index',
        '/main'        => 'secure'
    ];

    public function indexAction($name = null)
    {
        echo 'Hello '.$name.'!';
    }

    public function secureAction()
    {
        $token = $this->getApp()->request->post('token');
        $key = $this->getConfig()['apikey'];
        try {
            if ($this->getConfig()['jwt']->verifyToken($key, $token)) {
                print_r(json_encode(['response' => 'Secured content'], JSON_PRETTY_PRINT));
            } else {
                print_r(json_encode(['response' => 'Authentication failed'], JSON_PRETTY_PRINT));
            }
        } catch (\Exception $e) {
            print_r(json_encode(['response' => 'Authentication failed'], JSON_PRETTY_PRINT));
        }
    }
}
