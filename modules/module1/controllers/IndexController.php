<?php

namespace Module\Module1\Controller;

use Controller\ControllerAbstract;
use Model\Request;

class IndexController extends ControllerAbstract
{
    public function indexAction(Request $request) {
        var_dump($request);
        return $this;
    }
}