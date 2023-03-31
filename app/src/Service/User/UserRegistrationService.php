<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use App\Exception\ValidationException;
use App\Traits\EntityManagerTrait;
use App\Traits\ValidatorTrait;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserRegistrationService
{
    use EntityManagerTrait;
    use ValidatorTrait;

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param string $email
     * @param string $password
     * @return void
     *
     * @throws ValidationException
     */
    public function registerAdmin(string $email, string $password): void
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $user->setRoles([User::ROLE_ADMIN]);
        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new ValidationException($this->extractFirstErrorFromViolationList($errors));
        }

        $this->em->persist($user);
        $this->em->flush();
    }
}