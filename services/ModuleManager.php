<?php

namespace Service;

use Interfaces\LicenseManagerInterface;

class ModuleManager
{
    /**
     * @var LicenseManagerInterface
     */
    private $licenseManager = null;

    public function __construct(LicenseManagerInterface $licenseManager)
    {
        $this->licenseManager = $licenseManager;
    }

    /**
     * scans all modules and register classes, depending on given key
     */
    public function collectValidModules($key) {
        $modulesDirectory = __DIR__.'/../modules/';
        $modules = [];

        $directoryIterator = new \DirectoryIterator($modulesDirectory);

        foreach ($directoryIterator as $file) {
            if ($file->isDir()
                && !$file->isDot()
            ) {
                $bootstrapPath = $file->getPathname().'/Bootstrap.php';
                if (is_file($bootstrapPath)
                    && is_readable($bootstrapPath)
                ) {
                    /** @var \Interfaces\BootstrapInterface $class */
                    $class = $this->extractClassNameFromFilePath($bootstrapPath);
                    $currentModule = $class::getModuleLicense();
                    if (empty($currentModule)
                        || $this->licenseManager->checkModuleActive($key, $currentModule)
                    ) {
                        $modules['active'][$file->getFilename()] = $class;
                    } else {
                        $modules['inactive'][$file->getFilename()] = $class;
                    }
                }
            }
        }
        return $modules;
    }

    public function extractClassNameFromFilePath($path) {
        $fp = fopen($path, 'r');

        $class = $buffer = $namespace = '';
        while (!$class
            && !feof($fp)
        ) {
            $buffer .= fread($fp, 512);
            if (preg_match('/namespace (.*);/', $buffer, $matches)) {
                $namespace = $matches[1];
            }
            if (preg_match('/class\s+(\w+)(.*)?\{/s', $buffer, $matches)) {
                $class = $matches[1];
                break;
            }
        }
        fclose($fp);
        return !empty($namespace) ? $namespace.'\\'.$class : $class;
    }

}