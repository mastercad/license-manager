<?php

namespace Controller;

/**
 * class should place in external lib.
 */
abstract class ControllerAbstract
{
    public function call($action, $request)
    {
        $this->{$action.'Action'}($request);
    }
}