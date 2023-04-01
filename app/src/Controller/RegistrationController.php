<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationType;
use App\Service\User\UserRegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends AbstractController
{
    /**
     * @var UserRegistrationService
     */
    private $registrationService;

    public function __construct(UserRegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);
        $userRegistered = false;

        if ($request->isMethod(Request::METHOD_POST) && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $this->registrationService->registerUser($user, $user->getPassword());
            $userRegistered = true;
        }

        return $this->render('registration.html.twig', [
            'form' => $form->createView(),
            'userRegistered' => $userRegistered
        ]);
    }
}