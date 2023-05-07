<?php

namespace App\Command;

use App\Services\Telegram\TelegramReaderService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'TelegramBotCommand',
    description: 'Add a short description for your command',
)]
class TelegramBotCommand extends Command
{
    public TelegramReaderService $telegramReader;

    public function __construct(public ParameterBagInterface $parameterBag)
    {
        parent::__construct();
        $this->telegramReader = new TelegramReaderService($parameterBag);
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
        } catch (\Exception $e) {
            dd($e->getMessage());
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
