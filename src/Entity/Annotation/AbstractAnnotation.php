<?php

namespace Newage\Annotations\Entity\Annotation;

class AbstractAnnotation
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * Receive and process the contents of an annotation
     *
     * @param  array $data
     * @throws \Exception
     */
    public function __construct(array $data)
    {
        if (!isset($data['value']) || !is_array($data['value'])) {
            throw new \Exception(sprintf(
                '%s expects the annotation to define an array; received "%s"',
                get_class($this),
                isset($data['value']) ? gettype($data['value']) : 'null'
            ));
        }
        $this->value = $data['value'];
    }
}
