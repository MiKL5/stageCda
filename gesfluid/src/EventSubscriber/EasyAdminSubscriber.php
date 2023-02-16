<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
  private $userPasswordHasher;
  private $user;

  public function __construct(UserPasswordHasherInterface $userPasswordHasher, UserRepository $user)
  {
    $this->userPasswordHasher = $userPasswordHasher;
    $this->user = $user;
  }

  public static function getSubscribedEvents()
  {
    return [
      BeforeEntityPersistedEvent::class => ['generateUser'],
      BeforeEntityUpdatedEvent::class => ['updateUser'],
    ];
  }

  // Hash password, set user roles and user id based on the selected user group...
  public function generate(User $entity) 
  {
    $plainPassword = $entity->getPassword();

    $entity
      ->setPassword(
        $this->userPasswordHasher
             ->hashPassword($entity, $plainPassword)
      );

    $userId = $entity->getUserId();

    if (!$userId) {
      $userGroup = $entity->getUserGroup();
      $userCount = $this->user->getUserCountByGroup($userGroup->getId());
      $entity->setUserId($userGroup->getName() . $userCount + 1);
      if ($userGroup->getName() == 'ADMIN') {
        $entity->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
      } else {
        $entity->setRoles(['ROLE_USER']);
      }
    }
  }

  public function generateUser(BeforeEntityPersistedEvent $event)
  {
    $entity = $event->getEntityInstance();

    if (!($entity instanceof User)) {
      return;
    }

    $this->generate($entity);
  }

  public function updateUser(BeforeEntityUpdatedEvent $event)
  {
    $entity = $event->getEntityInstance();

    if (!($entity instanceof User)) {
      return;
    }

    $this->generate($entity);
  }
}

?>
