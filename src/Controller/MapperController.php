<?php

namespace Newage\Annotations\Controller;

use Newage\Annotations\Entity\Annotation\AnnotationBuilder;
use Newage\Annotations\Mapper\MapperBuilder;
use Zend\Console\ColorInterface as Color;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Mvc\Controller\AbstractConsoleController;

/**
 * @package Newage\Annotations\Controller
 */
class MapperController extends AbstractConsoleController
{
    /**
     * Generate mapper file
     */
    public function generateAction()
    {
        /* @var $console Console */
        $console = $this->getServiceLocator()->get('console');
        $config = $this->getServiceLocator()->get('config');

        $mapperBuilder = new MapperBuilder();
        $mapperBuilder->setConfig($config['annotations']['MapperBuilder']);

        $annotationBuilder = new AnnotationBuilder();
        $annotationBuilder->setOptions($config['annotations']['AnnotationBuilder']);
        $annotationBuilder->setMapperBuilder($mapperBuilder);
        $annotationBuilder->create();

        $console->writeLine('Map has been generated successful', Color::GREEN);
    }
}
