<?php

namespace Newage\Annotations\Mapper;

use Newage\Annotations\Config\MapperBuilderConfig;
use Zend\Stdlib\ArrayObject;
use Zend\Config\Writer\PhpArray;
use Zend\Config\Reader;

/**
 * @package Newage\Annotations\Mapper
 */
class MapperBuilder implements MapperBuilderInterface
{
    const MAPPER_NAME = 'mapping.php';

    /**
     * Path to save generated maps
     * @var string
     */
    protected $buildPath;

    /**
     * @var MapperBuilderConfig
     */
    private $config;

    /**
     * MapperBuilder constructor.
     *
     * @param MapperBuilderConfig $config
     */
    public function __construct(MapperBuilderConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Generate/update mapping
     * @param ArrayObject $spec
     */
    public function create(ArrayObject $spec)
    {
        $filePath = $this->config->getConfig('path') . self::MAPPER_NAME;
        $configArray = new ArrayObject();

        foreach ($spec['entities'] as $entity) {
            if (isset($entity['entity'])) {
                $configArray[$entity['entity']] = $entity;
                unset($entity['entity']);
            }
        }

        $writer = new PhpArray();
        $writer->setUseBracketArraySyntax(true);
        $writer->toFile($filePath, $configArray);
    }
}
