<?php

namespace Newage\Annotations\Mapper\Annotation;

use Newage\Annotations\Entity\Annotation;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;

/**
 * Class PropertyAnnotationListener
 * @package SimpleOrm\Mapper\Annotation
 */
class PropertyAnnotationListener extends AbstractAnnotationListener
{
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('configureProperty', [$this, 'handleIdAnnotation']);
        $this->listeners[] = $events->attach('configureProperty', [$this, 'handleColumnAnnotation']);
        $this->listeners[] = $events->attach('configureProperty', [$this, 'handleOneToOneAnnotation']);
        $this->listeners[] = $events->attach('configureProperty', [$this, 'handleOneToManyAnnotation']);
        $this->listeners[] = $events->attach('configureProperty', [$this, 'handleManyToManyAnnotation']);
    }

    public function handleIdAnnotation(EventInterface $event)
    {
        $annotation = $event->getParam('annotation');
        if (!$annotation instanceof Annotation\Id) {
            return;
        }

        $spec = $event->getParam('spec');
        $spec['autoincrement'] = true;
    }

    public function handleColumnAnnotation(EventInterface $event)
    {
        $annotation = $event->getParam('annotation');
        if (!$annotation instanceof Annotation\Column) {
            return;
        }

        $spec = $event->getParam('spec');
        $spec['column'] = $annotation->getName();
    }

    public function handleOneToOneAnnotation(EventInterface $event)
    {
        $annotation = $event->getParam('annotation');
        if (!$annotation instanceof Annotation\OneToOne) {
            return;
        }

        $spec = $event->getParam('spec');
        $spec['oneToOne'] = $annotation->getName();
    }

    public function handleOneToManyAnnotation(EventInterface $event)
    {
        $annotation = $event->getParam('annotation');
        if (!$annotation instanceof Annotation\OneToMany) {
            return;
        }

        $spec = $event->getParam('spec');
        $spec['oneToMany'] = $annotation->getName();
    }

    public function handleManyToManyAnnotation(EventInterface $event)
    {
        $annotation = $event->getParam('annotation');
        if (!$annotation instanceof Annotation\ManyToMany) {
            return;
        }

        $spec = $event->getParam('spec');
        $spec['manyToMany'] = $annotation->getName();
    }
}
