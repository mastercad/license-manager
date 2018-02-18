<?php

namespace Service;

use Interfaces\LicenseManagerInterface;

class LicenseManager implements LicenseManagerInterface
{
    const KEY_MODULE_1 = 128;
    const KEY_MODULE_2 = 1;
    const KEY_MODULE_3 = 16;

    public function checkModuleActive($license, $moduleKey) {
        return ($license & $moduleKey) === $moduleKey;
    }
}