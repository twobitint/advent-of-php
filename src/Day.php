<?php

namespace twobitint\AdventOfPHP;

use Symfony\Component\Console\Output\OutputInterface;

class Day implements Solves
{
    protected OutputInterface $output;

    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function p1(Input $input): int
    {
        return 0;
    }

    public function p2(Input $input): int
    {
        return 0;
    }
}