<?php

$config = [
    'annotations' => [
        'AnnotationBuilder' => [
            'models' => [
                [
                    'path' => 'examples/Model',
                    'namespace' => 'ExampleModel\Model'
                ]
            ]
        ],
        'MapperBuilder' => [
            'path' => 'build/'
        ]
    ],
    'controllers' => [
        'invokables' => [
            'MapperController' => '\Newage\Annotations\Controller\MapperController'
        ]
    ],
    'console' => [
        'router' => [
            'routes' => [
                'generate' => [
                    'options' => [
                        'route'    => 'mapper generate',
                        'defaults' => [
                            'controller' => 'MapperController',
                            'action'     => 'generate'
                        ]
                    ]
                ],
                'test' => [
                    'options' => [
                        'route'    => 'mapper test',
                        'defaults' => [
                            'controller' => 'MapperController',
                            'action'     => 'test'
                        ]
                    ]
                ]
            ]
        ]
    ]
];

return $config;
