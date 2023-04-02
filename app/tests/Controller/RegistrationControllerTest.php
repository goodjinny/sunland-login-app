<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\DatabaseDependantTestCase;

class RegistrationControllerTest extends DatabaseDependantTestCase
{
    public function testPageLoaded(): void
    {
        $client = static::createClient();

        $client->request('GET', '/registration');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('html h1', 'Registration');
    }

    public function testUserRegistration(): void
    {
        $client = static::createClient();
        $userRepository = self::$container->get(UserRepository::class);

        //Fill and submit the registration form
        $crawler = $client->request('GET', '/registration');
        $buttonCrawlerNode = $crawler->selectButton('Submit');
        $form = $buttonCrawlerNode->form([
            'user_registration[firstName]' => 'Test User',
            'user_registration[email]' => 'test_user@gmail.com',
            'user_registration[password][first]' => '!SecurePassword9',
            'user_registration[password][second]' => '!SecurePassword9',
        ]);
        $client->submit($form);
        $this->assertStringContainsString('Greetings, you are successfully registered', $client->getResponse()->getContent());

        //Check user
        $user = $userRepository->findByEmail('test_user@gmail.com');
        $this->assertNotNull($user);
        $this->assertEquals('Test User', $user->getFirstName());
        $this->assertContains(User::ROLE_USER, $user->getRoles());
        $this->assertNotContains(User::ROLE_ADMIN, $user->getRoles());
    }
}
