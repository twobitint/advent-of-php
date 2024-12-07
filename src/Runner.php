<?php

namespace twobitint\AdventOfPHP;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'run')]
class Runner extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day = $input->getOption('day') ?? date('d');
        $year = date('Y');

        $input = file_get_contents(__DIR__ . '/../input/' . $year . '/' . $day);

        require_once __DIR__ . '/helpers.php';
        require __DIR__ . '/../solutions/' . $year . '/' . $day . '.php';

        $output->writeln(\p1($input));
        $output->writeln(\p2($input));

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->addOption('day', 'd',  InputOption::VALUE_OPTIONAL, 'Day to run', date('d'));
    }
}