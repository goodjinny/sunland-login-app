<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use App\Service\User\UserRegistrationService;
use App\Tests\DatabaseDependantTestCase;

class LoginControllerTest extends DatabaseDependantTestCase
{
    public function testPageLoad(): void
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('html h1', 'Login');

    }

    public function testUserLogin(): void
    {
        $client = static::createClient();
        $userRepository = self::$container->get(UserRepository::class);
        $userRegistrationService = self::$container->get(UserRegistrationService::class);

        //Login to admin area failed
        $client->request('GET', '/admin');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        //Create user
        $userRegistrationService->registerAdmin('admin@sunland.dk', '!SecurePassword9');
        $user = $userRepository->findByEmail('admin@sunland.dk');
        $this->assertNotNull($user);
        $this->assertTrue($user->isAdmin());

        //Submit the login form
        $crawler = $client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form([
            'email'    => 'admin@sunland.dk',
            'password' => '!SecurePassword9',
        ]);
        $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('/admin', $client->getResponse()->headers->get('location'));

        //Check access to admin page
        $client->request('GET', '/admin');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('html h1', 'Admin');
    }
}