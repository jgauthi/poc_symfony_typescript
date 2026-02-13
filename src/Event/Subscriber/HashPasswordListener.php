<?php
namespace App\Event\Subscriber;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Encode password before insert/update on database (Doctrine Event Listener).
 */
#[AsDoctrineListener(event: Events::prePersist)]
#[AsDoctrineListener(event: Events::preUpdate)]
class HashPasswordListener
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    private function encodePassword(User $user): void
    {
        $password = $user->getPlainPassword();
        if (empty($password)) {
            return;
        }

        $hashed = $this->hasher->hashPassword($user, $password);
        $user->setPassword($hashed);
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof User) {
            return;
        }

        $this->encodePassword($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof User) {
            return;
        }

        $this->encodePassword($entity);
    }
}
