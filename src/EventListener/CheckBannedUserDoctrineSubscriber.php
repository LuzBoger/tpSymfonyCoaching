<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class CheckBannedUserDoctrineSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->checkIfBanned($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->checkIfBanned($args);
    }

    private function checkIfBanned(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof User && in_array('ROLE_BANNED', $entity->getRoles())) {
            throw new \Exception('Cannot persist or update a banned user!');
        }
    }
}