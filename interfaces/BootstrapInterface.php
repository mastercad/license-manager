<?php

namespace Interfaces;

interface BootstrapInterface
{
    static public function getModuleLicense();

    public function __construct(\Pimple\Container $container);

    public function register($inactive);
}