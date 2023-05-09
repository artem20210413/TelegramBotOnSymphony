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
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'TelegramBotCommand',
    description: 'Add a short description for your command',
)]
class TelegramBotCommand extends Command
{
    public TelegramReaderService $telegramReader;

    public function __construct(public ParameterBagInterface $parameterBag, public EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->telegramReader = new TelegramReaderService($parameterBag, $entityManager);
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
            return $e->getMessage();
        }

    }
}
