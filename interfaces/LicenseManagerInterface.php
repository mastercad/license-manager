<?php

namespace Interfaces;

interface LicenseManagerInterface
{
    public function checkModuleActive($license, $module);
}