<?php

namespace Newage\Annotations\Factory;

use Newage\Annotations\Config\AnnotationBuilderConfig;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AnnotationBuilderConfigFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        if (!isset($config['annotations']['AnnotationBuilder'])) {
            throw new \Exception('Configuration does not have options "AnnotationBuilder"');
        }

        $annotationConfig = new AnnotationBuilderConfig($config['annotations']['AnnotationBuilder']);
        return $annotationConfig;
    }
}
