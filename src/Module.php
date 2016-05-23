<?php

namespace Newage\Annotations;

use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

/**
 * @package Newage\Annotations
 */
class Module implements ConfigProviderInterface, ConsoleUsageProviderInterface
{
    public function getConsoleUsage(AdapterInterface $console)
    {
        $docs = [
            'Mapper:',
            'mapper generate' => 'Generate map from annotations of entity'
        ];

        return $docs;
    }

    public function getConfig()
    {
        $config = require '../config/module.config.php';
        return $config;
    }
}
