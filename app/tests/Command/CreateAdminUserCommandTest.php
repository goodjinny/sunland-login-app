<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Repository\UserRepository;
use App\Tests\DatabaseDependantTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CreateAdminUserCommandTest extends DatabaseDependantTestCase
{
    public function testCreateAdmin(): void
    {
        $application = new Application(self::$kernel);
        $command = $application->find('app:create-admin-user');
        $commandTester = new CommandTester($command);
        $userRepository = self::$container->get(UserRepository::class);

        $commandTester->execute([
            'email' => 'admin@sunland.dk',
            'password' => '!TestPassword379'
        ]);
        $this->assertStringContainsString('Admin user was successfully registered', $commandTester->getDisplay());

        $user = $userRepository->findByEmail('admin@sunland.dk');
        $this->assertNotNull($user);
        $this->assertTrue($user->isAdmin());
    }

    public function testFailCreateAdminWithWeakPassword(): void
    {
        $application = new Application(self::$kernel);
        $command = $application->find('app:create-admin-user');
        $commandTester = new CommandTester($command);
        $userRepository = self::$container->get(UserRepository::class);

        $commandTester->execute([
            'email' => 'admin@sunland.dk',
            'password' => 'weak-password'
        ]);
        $this->assertStringContainsString('[ERROR] Password should contain minimum eight characters', $commandTester->getDisplay());

        $user = $userRepository->findByEmail('admin@sunland.dk');
        $this->assertNull($user);
    }
}