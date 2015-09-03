<?php

namespace Slimvc;

use \Slim\Slim;

/**
* FrontController class
*/
class FrontController
{
    protected $controller;
    protected $action;
    protected $app;
    protected $config;

    public function __construct(Slim $app = null, $config)
    {
        $this->app = ($app instanceof Slim) ? $app : Slim::getInstance();
        $this->config = $config;

        return $this;
    }

    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    public function initController($payload = [])
    {
        $payload = is_string($payload) ? [$payload] : $payload;
        $controllerClass = (new $this->controller($this->app))->config($this->config);
        call_user_func_array([$controllerClass, $this->action], $payload);
    }

    public function init()
    {
        foreach (glob(APP_PATH.'/../app/Controller/*.php') as $controllerFileName) {
            require_once($controllerFileName);
            $controllerClass = APP_NAME."\\Controller\\" . ucfirst(basename($controllerFileName, '.php'));
            foreach ($controllerClass::$actions as $route => $actionName) {
                if (is_string($route)) {
                    $pathUrl = $route;
                } else {
                    $pathUrl = '/' . $controllerName . '/' . strtolower($actionName);
                }

                $currentController = (new self($this->app, $this->config))
                                        ->setController($controllerClass)
                                        ->setAction(strtolower($actionName) . 'Action');

                if ($this->app->request->isPost()) {
                    $this->app->post($pathUrl, [$currentController, 'initController']);
                } elseif ($this->app->request->isPut()) {
                    $this->app->put($pathUrl, [$currentController, 'initController']);
                } else {
                    $this->app->get($pathUrl, [$currentController, 'initController']);
                }
            }
        }
        $this->run();

        return $this;
    }

    public function run()
    {
        $this->app->run();
    }
}
