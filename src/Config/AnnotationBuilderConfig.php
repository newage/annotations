<?php

namespace Newage\Annotations\Config;

/**
 * @package Newage\Annotations\Config
 */
class AnnotationBuilderConfig
{
    /**
     * @var array
     */
    private $config;

    /**
     * AnnotationConfig constructor.
     *
     * @param array $config
     */
    public function __construct($config)
    {
        $this->setConfig($config);
    }

    /**
     * Set configuration
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get configuration or by name
     * @param string $key
     * @return array|mixed
     */
    public function getConfig($key = null)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }
        return $this->config;
    }
}
