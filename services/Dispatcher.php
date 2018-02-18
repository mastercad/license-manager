<?php

namespace Service;

use Exception\HttpNotFoundException;
use Model\Request;
use Pimple\Container;

/**
 * Dispatcher class to handle requests from http and cli.
 */
class Dispatcher
{
    /**
     * public dispatch function to handle requests.
     *
     * @param Request $request
     * @param Container $container
     *
     * @return Dispatcher
     */
    public function dispatch(Request $request, Container $container)
    {
        if (Request::REQUEST_TYPE_HTTP === $request->getRequestType()) {
            $this->forward($request, $container);
        }

        return $this;
    }

    /**
     * forwards request to prepared module/controller/action.
     *
     * @param Request $request
     * @param Container $container
     *
     * @return Dispatcher
     *
     * @throws HttpNotFoundException
     */
    public function forward(Request $request, Container $container)
    {
        $controllerKeyName = '';

        if ('index' !== $request->getModule()) {
            $controllerKeyName = mb_strtolower($request->getModule()).'.controller.'.mb_strtolower($request->getController());
        } else {
            $controllerKeyName = 'controller.'.mb_strtolower($request->getController());
        }
        if (!$container->offsetExists($controllerKeyName)) {
            throw new HttpNotFoundException($controllerKeyName.' not found!');
        }

        if (is_string($container[$controllerKeyName])) {
            $controllerClass = new $container[$controllerKeyName];
            $controllerClass->call($request->getAction(), $request);
        } else {
            $container[$controllerKeyName]($request->getAction(), $request);
        }
        return $this;
    }
}
