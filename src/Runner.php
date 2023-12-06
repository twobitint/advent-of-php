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
        $day = $input->getOption('day');
        $solver = include(__DIR__ . '/../solutions/2023/' . $day . '.php');
        $solver->setDay($day);
        $solver->setOutput($output);
        $output->writeln($solver->p1());
        $output->writeln($solver->p2());

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->addOption('day', 'd',  InputOption::VALUE_OPTIONAL, 'Day to run', date('d'));
    }
}