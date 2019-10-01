<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command {

    private $em;
    private $userPasswordEncoder;
    private $userRepository;

    protected static $defaultName = 'app:create-user';

    public function __construct(
        EntityManagerInterface $em, 
        UserPasswordEncoderInterface $userPasswordEncoder,
        UserRepository $userRepository
    ) {
        parent::__construct();
        $this->em = $em;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->userRepository = $userRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('This command allows you to create a user')
            ->setHelp('This command requires two arguments: email and password')
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'user\'s email'
            )
            ->addArgument(
                'password',
                InputArgument::REQUIRED,
                'user\'s password'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $user = new User();
        $user->setEmail($email);
        $password = $this->userPasswordEncoder->encodePassword($user, $password);
        $user->setPassword($password);
        $this->em->persist($user);
        $this->em->flush($user);
        $output->writeln('<fg=white;bg=cyan>usuario creado con id: '.$user->getId().'</>');
    }
}