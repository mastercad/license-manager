<?php
namespace Module\Module2;

use Service\LicenseManager;

class Bootstrap extends \BootstrapAbstract
{
    static protected $moduleLicense = LicenseManager::KEY_MODULE_2;

    protected $classes = [
        'module2.service' => 'Module\Module2\Service\ModuleService',
        'module2.controller.index' => 'Module\Module2\Controller\IndexController',
    ];

}
