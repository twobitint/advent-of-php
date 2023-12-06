<?php

namespace twobitint\AdventOfPHP;

use Symfony\Component\Console\Output\OutputInterface;

class Day implements Solves
{
    public string $input;
    public OutputInterface $output;

    public function setDay($day)
    {
        $this->input = file_get_contents(__DIR__ . "/../input/2023/$day");
    }

    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function p1()
    {
        return 0;
    }

    public function p2()
    {
        return 0;
    }
}