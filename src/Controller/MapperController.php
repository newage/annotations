<?php

namespace Newage\Annotations\Controller;

use Newage\Annotations\Entity\Annotation\AnnotationBuilderInterface;
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
     * @var AnnotationBuilderInterface
     */
    private $annotationBuilder;

    /**
     * MapperController constructor.
     *
     * @param AnnotationBuilderInterface $annotationBuilder
     */
    public function __construct(AnnotationBuilderInterface $annotationBuilder)
    {
        $this->annotationBuilder = $annotationBuilder;
    }
    
    /**
     * Generate mapper file
     */
    public function generateAction()
    {
        /* @var $console Console */
        $console = $this->getServiceLocator()->get('console');

        $this->annotationBuilder->create();

        $console->writeLine('Map has been generated successful', Color::GREEN);
    }
}
