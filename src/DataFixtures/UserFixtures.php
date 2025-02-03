<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            ['email' => 'admin@example.com', 'roles' => ['ROLE_ADMIN'], 'password' => 'admin123'],
            ['email' => 'manager@example.com', 'roles' => ['ROLE_MANAGER'], 'password' => 'manager123'],
            ['email' => 'user@example.com', 'roles' => ['ROLE_USER'], 'password' => 'user123'],
        ];

        foreach ($users as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setFirstname('First');
            $user->setLastname('Last');
            $user->setRoles($data['roles']);
            $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
