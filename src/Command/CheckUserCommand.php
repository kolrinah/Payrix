<?php
/**
 * Created by PhpStorm.
 * User: hector
 * Date: 7/2/18
 * Time: 3:36 PM
 */
namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;
use Doctrine\ORM\EntityManagerInterface;

class CheckUserCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'payrix:check-user';

    /** @var SymfonyStyle */
    private $io;

    private $em;


    public function __construct(?string $name = null, EntityManagerInterface $em) {
        parent::__construct($name);
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName(static::$defaultName)
            // the short description shown while running "php bin/console list"
            ->setDescription('Check user in database.')

            ->addOption('multi','m' , InputOption::VALUE_OPTIONAL, 'Check multiple users')

            // configure an argument
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to check if username exists...')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->title('Interactive User checking');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $user = $input->getArgument('username');
        $multi = $input->getOption('multi');

        if ($user === '\quit') {
            $this->io->comment('Thanks for your time');
            return 0;
        }
        $this->io->title('Checking Username: ' . $user);

        $userDb = $this->em->getRepository('App:User')->findOneBy(['username' => $user ]);

        if (empty($userDb)) {
            $this->io->warning(sprintf('%s not found in Database.', $user));
        } else {
            $this->io->success("User {$userDb->getFullname()} ({$user}) has been successfully found in Database.");
        }

        if ($multi == 'true') {
            $command = $this->getApplication()->find(static::$defaultName);
            $arguments = array(
                'command' => static::$defaultName,
                '--multi' => 'true',
            );
            $greetInput = new ArrayInput($arguments);
            $command->run($greetInput, $output);
        }
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        foreach ($input->getArguments() as $option => $value) {
            if (null === $value) {
                $input->setArgument($option, $this->io->ask(sprintf('%s', ucfirst($option))));
            }
        }
    }
}