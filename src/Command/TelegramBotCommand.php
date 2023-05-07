<?php

namespace App\Command;

use App\Services\Telegram\TelegramReaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'TelegramBotCommand',
    description: 'Add a short description for your command',
)]
class TelegramBotCommand extends Command
{
    public TelegramReaderService $telegramReader;

<<<<<<< HEAD
    public function __construct(public ParameterBagInterface $parameterBag, public EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->telegramReader = new TelegramReaderService($parameterBag, $entityManager);
=======
    public function __construct()
    {
        parent::__construct();
        $this->telegramReader = new TelegramReaderService();
>>>>>>> parent of 2e4040f (moved project in symfony)
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        try {
            $offset = 0;

            while (true) {
                $offset = $this->telegramReader->getUpdates($offset);
                echo 'offset: ' . $offset . '. At work...' . PHP_EOL;
                sleep(1);
            }
        } catch (\InvalidArgumentException $e) {
            return $e->getMessage();
        }
//        $io = new SymfonyStyle($input, $output);
//        $arg1 = $input->getArgument('arg1');
//
//        if ($arg1) {
//            $io->note(sprintf('You passed an argument: %s', $arg1));
//        }
//
//        if ($input->getOption('option1')) {
//            // ...
//        }
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
//
//        return Command::SUCCESS;
    }
}
