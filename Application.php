<?php

use Pimple\Container;
use \Service\LicenseManager;
use \Service\ModuleManager;
use \Service\Request as RequestService;
use \Model\Request as RequestModel;
use \Service\Dispatcher;
use \Exception\ModuleInactiveException;

class Application
{
    /**
     * @var Container $container
     */
    private $container = null;

    /**
     * @var LicenseManager $licenseManager
     */
    private $licenseManager = null;

    /**
     * @var ModuleManager $moduleManager
     */
    private $moduleManager = null;

    /**
     * @var array $modules
     */
    private $modules = [];

    /**
     * @var string $key
     */
    private $key = null;

    /**
     * @var \Model\Request $request
     */
    private $request = null;

    /**
     * @var bool false
     */
    private $isCli = false;

    public function __construct($request, $isCli)
    {
        $this->request = $this->prepare($request);
        $this->isCli = $isCli;
    }

    /**
     * Prepare the request from FE or CLI with Request Service and returns Request model.
     *
     * @param array $request
     *
     * @return RequestModel
     */
    public function prepare($request)
    {
        $requestService = new RequestService();
        return $requestService->parse($request, $this->isCli);
    }

    /**
     * run Application.
     *
     * @return Application
     */
    public function run()
    {
        $this->key = LicenseManager::KEY_MODULE_1|LicenseManager::KEY_MODULE_3;
        $this->bootstrap();

        try {
            $dispatcher = new Dispatcher();
            $dispatcher->dispatch($this->request, $this->container);
        } catch (ModuleInactiveException $exception) {
            echo $exception->getMessage().PHP_EOL;
        }

        return $this;
    }

    /**
     * Bootstrapping Process for Application.
     *
     * @return Application
     */
    private function bootstrap()
    {
        $this->container = new Container([]);
        $this->licenseManager = new LicenseManager();
        $this->moduleManager = new ModuleManager($this->licenseManager);
        $this->modules = $this->moduleManager->collectValidModules($this->key);

        /** @var BootstrapAbstract $bootstrap */
        foreach ($this->modules['active'] as $moduleName => $bootstrapClass) {
            $bootstrap = new $bootstrapClass($this->container);
            $bootstrap->register(true);
        }

        foreach ($this->modules['inactive'] as $moduleName => $bootstrapClass) {
            $bootstrap = new $bootstrapClass($this->container);
            $bootstrap->register(false);
        }

        return $this;
    }
}
