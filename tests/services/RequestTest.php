<?php

namespace Test\Service;

use Model\Request as RequestModel;
use Service\Request as RequestService;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /**
     * @dataProvider resolveHttpRequestDataProvider
     */
    public function testResolveHttpRequest($requestUri, $requestType, $expectedParams)
    {
        $requestModel = new RequestModel();
        $requestService = new RequestService();

        $requestModel->setRequestUri($requestUri)
            ->setRequestType($requestType);
        $requestService->resolveHttpRequest($requestModel);

        $this->assertEquals($expectedParams, $requestModel->getParams());
    }

    public function resolveHttpRequestDataProvider()
    {
        return [
            [
                'requestUri' => 'http://www.test.de/module/controller/action/id/10/pass/sdasa/asasa/',
                'requestType' => RequestModel::REQUEST_TYPE_HTTP,
                'expectedParams' => [
                    'id' => '10',
                    'pass' => 'sdasa',
                    'asasa' => '',
                ],
            ],
        ];
    }
}
