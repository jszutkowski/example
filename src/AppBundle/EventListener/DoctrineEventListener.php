<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\User;

/**
 * Description of EmailChangeListener
 *
 * @author Jarek
 */
class DoctrineEventListener
{
    protected $container;
    
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function postUpdate(LifecycleEventArgs $event)
    {
        $object = $event->getObject();
        
        if ($object instanceof User && $object->isEmailChanged())
        {
            $this->container->get('stats_system')->postRequest($object);
            $this->container->get('marketing_system')->postRequest($object);
            $this->container->get('logger')->info("New email for user with id {$object->getId()}: {$object->getEmail()}");
        }
    }       

}
