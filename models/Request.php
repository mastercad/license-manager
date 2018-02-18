<?php

namespace Model;

class Request
{
    const REQUEST_TYPE_CLI = 'request_type_cli';
    const REQUEST_TYPE_HTTP = 'request_type_http';

    private $params = [];

    private $requestType = null;

    private $requestUri = null;

    private $module = 'index';

    private $controller = 'index';

    private $action = 'index';

    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setRequestType($requestType)
    {
        $this->requestType = $requestType;
        return $this;
    }

    public function getRequestType()
    {
        return $this->requestType;
    }

    public function setRequestUri($requestUri)
    {
        $this->requestUri = $requestUri;
        return $this;
    }

    public function getRequestUri()
    {
        return $this->requestUri;
    }

    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }
}