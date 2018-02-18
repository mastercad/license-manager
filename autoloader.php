<?php

function LicenseManagerAutoLoader($class)
{
    $pluralMap = [
        'Test' => 'tests',
        'Model' => 'models',
        'Module' => 'modules',
        'Service' => 'services',
        'Exception' => 'exceptions',
        'Controller' => 'controllers',
        'Collection' => 'collections',
    ];

    $parts = explode('\\', $class);
    $classPath = __DIR__;
    foreach ($parts as $index => $part) {
        if ($index < count($parts) - 1) {
            if (array_key_exists($part, $pluralMap)) {
                $part = $pluralMap[$part];
            }
            $classPath .= '/'.mb_strtolower($part);
        } else {
            $classPath .= '/'.$part.'.php';
        }
    }
    if (file_exists($classPath)
        && is_readable($classPath)
    ) {
        include $classPath;
        return true;
    }
    return false;
}

spl_autoload_register('LicenseManagerAutoLoader');