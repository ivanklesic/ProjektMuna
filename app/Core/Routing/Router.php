<?php declare(strict_types = 1);

namespace App\Core\Routing;

use App\Core\Exception\RouterException;
use App\Core\Request\RequestInterface;

class Router implements RouterInterface
{
    private RequestInterface $request;
    public const URL_SUFFIX = '.html';
    public const CONTROLLER_NAMESPACE = '\\App\\Controller\\';
    private array $supportedHttpMethods = array(
        "GET",
        "POST"
    );

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    private function invalidURLHandler($path)
    {
        throw new RouterException("{$path} is not a valid URL");
    }

    private function missingControllerHandler($controller)
    {
        throw new RouterException("{$controller} doesn't exist");
    }

    private function missingActionHandler($controller, $action)
    {
        throw new RouterException("{$action} doesn't exist in {$controller}");
    }

    private function invalidMethodHandler()
    {
        throw new RouterException("{$this->request->serverProtocol} 405 Method Not Allowed");
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function matchRoute($path)
    {
        if(!in_array($this->request->requestMethod, $this->supportedHttpMethods))
        {
            $this->invalidMethodHandler();
        }

        $path = trim($path, '/');
        $path = str_replace(self::URL_SUFFIX, '', $path);
        $parts = $path ? explode('/', $path) : [];

        if (count($parts) > 2) {
            $this->invalidURLHandler($path);
        }

        $controller = ucfirst(strtolower($parts[0] ?? 'home')) . 'Controller';
        $method = strtolower($parts[1] ?? 'index') . 'Action';

        $controllerClassName = self::CONTROLLER_NAMESPACE . $controller;

        $this->dispatch($controllerClassName, $method);
    }

    public function dispatch($controller, $action)
    {
        if(!class_exists($controller))
        {
            $this->missingControllerHandler($controller);
        }

        $controllerObject = new $controller();

        if(!method_exists($controller, $action))
        {
            $this->missingActionHandler($controller, $action);
        }

        return $controllerObject->$action();
    }
}