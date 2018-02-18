<?php

namespace Service;

use Model\Request as RequestModel;

/**
 * Class to parse Http and CLI request params and set in Request Model.
 */
class Request
{
    /**
     * @param array $request
     *
     * @return \Model\Request
     */
    public function parse($request, $isCli)
    {
        $requestModel = new RequestModel();
        if ($isCli) {
            $requestModel->setRequestUri($request[0]);
        } else {
            $requestModel->setRequestUri($_SERVER['REQUEST_URI']);
        }
        $requestModel->setParams($request);
        $requestModel->setRequestType(
            $isCli ? RequestModel::REQUEST_TYPE_CLI : RequestModel::REQUEST_TYPE_HTTP
        );

        if (false === $isCli) {
            $this->resolveHttpRequest($requestModel);
        }
        return $requestModel;

    }

    /**
     * Resolve http request from FE and parses data in model members.
     *
     * @param RequestModel $request
     *
     * @return Request
     */
    public function resolveHttpRequest(RequestModel $request)
    {
        $requestUri = $request->getRequestUri();
        $requestParams = parse_url($requestUri);

        $params = explode('/', $requestParams['path']);

        for($pos = 0; $pos < count($params); ++$pos) {
            if (empty(trim($params[$pos]))) {
                continue;
            }
            if (4 <= count($params)) {
                if (1 === $pos) {
                    $request->setModule($params[$pos]);
                } elseif (2 === $pos) {
                    $request->setController($params[$pos]);
                } elseif (3 === $pos) {
                    $request->setAction($params[$pos]);
                } else {
                    $request->setParams(array_merge($request->getParams(), [$params[$pos] => $params[++$pos]]));
                }
            } else if (3 === count($params)) {
                if (1 === $pos) {
                    $request->setController($params[$pos]);
                } elseif (2 === $pos) {
                    $request->setAction($params[$pos]);
                }
            } else if (2 === count($params)) {
                $request->setAction($params[$pos]);
            }
        }

        if (!empty($requestParams['query'])) {
            $params = explode('&', $requestParams['query']);
            for($pos = 0; $pos < count($params); ++$pos) {
                @list($key, $value) = explode('=', $params[$pos]);
                $request->setParams(array_merge($request->getParams(), [$key => $value]));
            }
        }

        return $this;
    }
}
