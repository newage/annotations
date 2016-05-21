<?php

namespace Newage\Annotations\Factory;

use Newage\Annotations\Config\MapperBuilderConfig;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MapperBuilderConfigFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        if (!isset($config['annotations']['MapperBuilder'])) {
            throw new \Exception('Configuration does not have options "MapperBuilder"');
        }

        $mapperConfig = new MapperBuilderConfig($config['annotations']['MapperBuilder']);
        return $mapperConfig;
    }
}
