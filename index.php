<?php

require_once 'vendor/autoload.php';
require_once 'autoloader.php';

$isCli = php_sapi_name() === 'cli';

$application = new Application($isCli ? $argv : $_REQUEST, $isCli);
$application->run();
