<?php
namespace Module\Module1;

use Service\LicenseManager;

class Bootstrap extends \BootstrapAbstract
{
    static protected $moduleLicense = LicenseManager::KEY_MODULE_1;

    protected $classes = [
        'module1.service' => 'Module\Module1\Service\ModuleService',
        'module1.controller.index' => 'Module\Module1\Controller\IndexController',
    ];
}
