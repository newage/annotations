<?php

use Newage\Annotations\Controller;
use Newage\Annotations\Mapper;
use Newage\Annotations\Entity\Annotation;
use Newage\Annotations\Factory;
use Newage\Annotations\Config;

$config = [
    'di' => [
        'allowed_controllers' => [
            Controller\MapperController::class,
        ],
        'instance' => [
            'preference' => [
                Mapper\MapperBuilderInterface::class => Mapper\MapperBuilder::class,
                Annotation\AnnotationBuilderInterface::class => Annotation\AnnotationBuilder::class,
                \Zend\EventManager\EventManagerInterface::class => \Zend\EventManager\EventManager::class,
            ]
        ],
        'definition' => [
            'class' => [
                Annotation\AnnotationBuilder::class => [
                    'setEventManager' => ['required' => true],
                    'setAnnotationParser' => ['required' => true],
                    'setAnnotationManager' => ['required' => true],
                ]
            ]
        ]
    ],
    'service_manager' => [
        'factories' => [
            Config\MapperBuilderConfig::class => Factory\MapperBuilderConfigFactory::class,
            Config\AnnotationBuilderConfig::class => Factory\AnnotationBuilderConfigFactory::class,
        ]
    ],
    'console' => [
        'router' => [
            'routes' => [
                'mapper-generate' => [
                    'options' => [
                        'route'    => 'mapper generate',
                        'defaults' => [
                            'controller' => Controller\MapperController::class,
                            'action'     => 'generate'
                        ]
                    ]
                ]
            ]
        ]
    ]
];

return $config;
