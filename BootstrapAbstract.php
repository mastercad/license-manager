<?php

/**
 *
 */
abstract class BootstrapAbstract implements \Interfaces\BootstrapInterface
{
    /**
     * @var string license key for current module (empty means no license needed).
     */
    static protected $moduleLicense = '';

    /**
     * @var array classes for current module
     */
    protected $classes = [];

    /**
     * @var \Pimple\Container
     */
    private $container = null;

    /**
     * @param \Pimple\Container $container
     */
    public function __construct(\Pimple\Container $container) {
        $this->container = $container;
    }

    /**
     * register in member $classes existing classes.
     *
     * @param bool $active
     *
     * @return BootstrapAbstract
     */
    public function register($active)
    {
        foreach ($this->classes as $key => $class) {
            if ($active) {
                $this->container[$key] = $class;
            } else {
                $this->container[$key] = function() use ($class) {
                    $parts = explode('\\', $class);
                    $module = $parts[1];
                    throw new \Exception\ModuleInactiveException('Module '.$module.' not activated!');
                };
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    static public function getModuleLicense()
    {
        return static::$moduleLicense;
    }
}