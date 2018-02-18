<?php
namespace Module\Module3;

use Service\LicenseManager;

class Bootstrap extends \BootstrapAbstract
{
    static protected $moduleLicense = LicenseManager::KEY_MODULE_3;

    protected $classes = [
        'module3.service' => 'Module\Module3\Service\ModuleService',
        'module3.controller.index' => 'Module\Module3\Controller\IndexController',
    ];
}
