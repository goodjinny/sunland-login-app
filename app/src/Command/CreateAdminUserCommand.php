<?php

namespace App\Command;

use App\Exception\ValidationException;
use App\Service\User\UserRegistrationService;
use App\Traits\ValidatorTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateAdminUserCommand extends Command
{
    use ValidatorTrait;

    protected static $defaultName = 'app:create-admin-user';
    protected static $defaultDescription = 'Create an admin user';
    /**
     * @var UserRegistrationService
     */
    private $registrationService;

    public function __construct(UserRegistrationService $registrationService, string $name = null)
    {
        parent::__construct($name);
        $this->registrationService = $registrationService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('email', InputArgument::REQUIRED, 'Enter user email as a login')
            ->addArgument('password', InputArgument::REQUIRED, 'Enter user password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        try {
            $this->registrationService->registerAdmin($email, $password);
            $io->success('Admin user was successfully registered');
        } catch (ValidationException $e) {
            $io->error($e->getMessage());
        }

        return 0;
    }
}
