<?php

namespace Newage\Annotations\Entity\Annotation;

use Newage\Annotations\Config\AnnotationBuilderConfig;
use Newage\Annotations\Mapper\Annotation\EntityAnnotationListener;
use Newage\Annotations\Mapper\Annotation\PropertyAnnotationListener;
use Newage\Annotations\Mapper\MapperBuilder;
use Zend\Code\Annotation\AnnotationCollection;
use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Annotation\Parser;
use Zend\Code\Reflection\ClassReflection;
use Zend\Code\Reflection\PropertyReflection;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Stdlib\ArrayObject;

/**
 * @package Newage\Annotations\Mapper\Annotation
 */
class AnnotationBuilder implements EventManagerAwareInterface, AnnotationBuilderInterface
{
    /**
     * @var MapperBuilder
     */
    protected $mapperBuilder;

    /**
     * @var Parser\DoctrineAnnotationParser
     */
    protected $annotationParser;

    /**
     * @var AnnotationManager
     */
    protected $annotationManager;

    /**
     * @var EventManagerInterface
     */
    protected $events;

    /**
     * @var AnnotationBuilderConfig
     */
    private $config;

    /**
     * @var array Default annotations to register
     */
    protected $defaultAnnotations = [
        'Table',
        'Id',
        'Column',
        'OneToOne',
        'OneToMany',
        'ManyToOne',
        'ManyToMany',
    ];

    /**
     * AnnotationBuilder constructor.
     *
     * @param AnnotationBuilderConfig $config
     * @param MapperBuilder           $mapperBuilder
     */
    public function __construct(AnnotationBuilderConfig $config, MapperBuilder $mapperBuilder)
    {
        $this->mapperBuilder = $mapperBuilder;
        $this->config = $config;
    }

    /**
     * Create annotations from entity
     * @return ArrayObject
     */
    public function create()
    {
        $spec = new ArrayObject(['entities' => []]);
        $factory = $this->mapperBuilder;
        $modelsOptions = $this->config->getConfig('models');
        foreach ($modelsOptions as $modelOption) {
            if (!is_readable($modelOption['path'])) {
                continue;
            }
            foreach (new \FilesystemIterator($modelOption['path']) as $file) {
                $entityName = substr($file->getFileName(), 0, -4);
                $entityNamespace = '\\' . $modelOption['namespace'] . '\\' . $entityName;

                if (!class_exists($entityNamespace)) {
                    continue;
                }

                $class = new \ReflectionClass($entityNamespace);
                if (!$class->getConstructor()) {
                    $entity = new $entityNamespace();
                    $spec['entities'][] = $this->getSpecification($entity);
                }
            }
        };
        $factory->create($spec);
    }

    /**
     * @param $entity
     * @return ArrayObject
     * @internal param $spec
     */
    protected function getSpecification($entity)
    {
        $annotationManager = $this->getAnnotationManager();

        $spec = new ArrayObject();
        $reflection  = new ClassReflection($entity);
        $annotations = $reflection->getAnnotations($annotationManager);

        if ($annotations instanceof AnnotationCollection) {
            $this->configureEntity($annotations, $reflection, $spec);
        }

        foreach ($reflection->getProperties() as $property) {
            $annotations = $property->getAnnotations($annotationManager);

            if ($annotations instanceof AnnotationCollection) {
                $this->configureProperty($annotations, $property, $spec);
            }
        }

        return $spec;
    }

    /**
     * @param AnnotationCollection $annotations
     * @param ClassReflection      $reflection
     * @param ArrayObject          $spec
     */
    protected function configureEntity($annotations, $reflection, $spec)
    {
        $name = $reflection->getName();
        $spec['entity'] = $name;

        $events = $this->getEventManager();
        foreach ($annotations as $annotation) {
            $events->trigger(
                __FUNCTION__,
                $this,
                [
                    'annotation' => $annotation,
                    'spec'       => $spec,
                    'name'       => $name
                ]
            );
        }
    }

    /**
     * @param AnnotationCollection $annotations
     * @param PropertyReflection   $reflection
     * @param ArrayObject          $spec
     */
    protected function configureProperty($annotations, $reflection, $spec)
    {
        $name = $reflection->getName();
        $propertySpec = new ArrayObject([
            'property' => $name
        ]);

        $events = $this->getEventManager();
        foreach ($annotations as $annotation) {
            $events->trigger(
                __FUNCTION__,
                $this,
                [
                    'annotation' => $annotation,
                    'spec'       => $propertySpec,
                    'name'       => $name
                ]
            );
        }

        if (!isset($spec['properties'])) {
            $spec['properties'] = [];
        }
        $spec['properties'][] = $propertySpec;
    }

    /**
     * Set event manager instance
     *
     * @param  EventManagerInterface $events
     * @return AnnotationBuilder
     */
    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers([
            __CLASS__,
            get_class($this),
        ]);
        $events->attach(new EntityAnnotationListener());
        $events->attach(new PropertyAnnotationListener());
        $this->events = $events;
        return $this;
    }

    /**
     * Get event manager
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }

    /**
     * @return mixed
     */
    public function getAnnotationManager()
    {
        if (null === $this->annotationManager) {
            $this->setAnnotationManager(new AnnotationManager());
        }

        return $this->annotationManager;
    }

    /**
     * @param mixed $annotationManager
     */
    public function setAnnotationManager(AnnotationManager $annotationManager)
    {
        $parser = $this->getAnnotationParser();
        foreach ($this->defaultAnnotations as $annotationName) {
            $class = __NAMESPACE__ . '\\' . $annotationName;
            $parser->registerAnnotation($class);
        }
        $annotationManager->attach($parser);
        $this->annotationManager = $annotationManager;
    }

    /**
     * @return \Zend\Code\Annotation\Parser\DoctrineAnnotationParser
     */
    public function getAnnotationParser()
    {
        if (null === $this->annotationParser) {
            $this->annotationParser = new Parser\DoctrineAnnotationParser();
        }

        return $this->annotationParser;
    }
}
