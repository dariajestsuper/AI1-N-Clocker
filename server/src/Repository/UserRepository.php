<?php

namespace App\Repository;

use App\Configuration\EntityManager;
use App\Entity\User;
use App\Exception\AuthException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class UserRepository extends EntityRepository
{
    public static function create(?\Doctrine\ORM\EntityManager $em = null): self
    {
        return new UserRepository($em ?? EntityManager::getEntityManager(), new ClassMetadata(User::class));
    }

    public function login(string $username, string $password): User
    {
        $user = $this->findOneBy(['username' => $username]);
        if (!$user instanceof User) {
            throw new AuthException('User not found!');
        }
        if ($user->getPassword() !== hash('sha256', $password)) {
            throw new AuthException('Wrong password!');
        }
        return $user;
    }

    public function register(string $username, string $password) {
        if(!!$this->count(['username'=>$username])){
            throw new AuthException('Username taken!');
        }
        $user = new User();
        $user->setUsename($username);
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();
    }
}