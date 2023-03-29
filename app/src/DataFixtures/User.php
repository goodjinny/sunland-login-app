<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class User extends Fixture
{
    private const ADMIN_PASSWORD = 'some_secure_password';
    const ADMIN_LOGIN = 'admin@sunland.dk';

    /**
     * @var PasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new \App\Entity\User();
        $user->setEmail(self::ADMIN_LOGIN);
        $user->setPassword($this->passwordEncoder->encodePassword($user, self::ADMIN_PASSWORD));
        $user->setRoles([\App\Entity\User::ROLE_ADMIN]);
        $manager->persist($user);
        $manager->flush();
    }
}
