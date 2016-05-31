<?php

namespace Newage\Annotations\Entity\Annotation;

/**
 * @Annotation
 */
class OneToMany extends AbstractAnnotation
{
    /**
     * Retrieve the name
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->value;
    }
}
