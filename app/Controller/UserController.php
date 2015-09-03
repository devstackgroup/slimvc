<?php

namespace Sample\Controller;

use Slimvc\Controller;
use Sample\Model\User;

/**
* UserController
*/
class UserController extends Controller
{
    public static $actions = [
      '/users'     => 'index',
      '/user/:id+' => 'user'
    ];

    public function indexAction()
    {
        header('X-Access-Token: '.$this->getConfig()['jwt']->getToken());
        $user = new User($this->getConfig()['db']);
        print_r(json_encode(['response' => $user->get()], JSON_PRETTY_PRINT));
    }

    public function userAction(...$id)
    {
        $name = implode(' ', $id);
        header('X-Access-Token: '.$this->getConfig()['jwt']->getToken());
        $user = new User($this->getConfig()['db']);
        print_r(json_encode(['response' => $user->get(['id' => $id[0]])], JSON_PRETTY_PRINT));
    }
}
