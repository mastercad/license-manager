<?php

namespace Test\Service;

use PHPUnit\Framework\TestCase;
use Service\LicenseManager;

class LicenseManagerTest extends TestCase
{
    /**
     * @dataProvider checkModuleActiveDataProvider
     */
    public function testCheckModuleActive($license, $key, $expectation)
    {
        $licenseManager = new LicenseManager();
        $this->assertSame($expectation, $licenseManager->checkModuleActive($license, $key));
    }

    public function checkModuleActiveDataProvider()
    {
        return [
            [
                'license' => LicenseManager::KEY_MODULE_1 | LicenseManager::KEY_MODULE_2,
                'key' => LicenseManager::KEY_MODULE_1,
                'expectation' => true,
            ],[
                'license' => LicenseManager::KEY_MODULE_1 | LicenseManager::KEY_MODULE_2,
                'key' => LicenseManager::KEY_MODULE_3,
                'expectation' => false,
            ],[
                'license' => LicenseManager::KEY_MODULE_1 | LicenseManager::KEY_MODULE_2 | LicenseManager::KEY_MODULE_3,
                'key' => LicenseManager::KEY_MODULE_1,
                'expectation' => true,
            ],[
                'license' => LicenseManager::KEY_MODULE_1 | LicenseManager::KEY_MODULE_2 | LicenseManager::KEY_MODULE_3,
                'key' => LicenseManager::KEY_MODULE_2,
                'expectation' => true,
            ],[
                'license' => LicenseManager::KEY_MODULE_1 | LicenseManager::KEY_MODULE_2 | LicenseManager::KEY_MODULE_3,
                'key' => LicenseManager::KEY_MODULE_3,
                'expectation' => true,
            ],[
                'license' => LicenseManager::KEY_MODULE_2,
                'key' => LicenseManager::KEY_MODULE_1,
                'expectation' => false,
            ],[
                'license' => LicenseManager::KEY_MODULE_2 | LicenseManager::KEY_MODULE_3,
                'key' => LicenseManager::KEY_MODULE_1,
                'expectation' => false,
            ],
        ];
    }
}