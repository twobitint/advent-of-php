<?php

use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;

return new class extends Day {

    public function p1(Input $input): int
    {
        return $this->multiply($this->parse($input));
    }

    public function p2(Input $input): int
    {
        $memory = $this->parse($input);
        $doChunks = explode("do()", $memory);

        return collect($doChunks)
            ->reduce(function ($carry, $chunk) {
                [$doMemory,] = explode("don't()", $chunk);
                return $carry + $this->multiply($doMemory);
            }, 0);
    }

    protected function multiply($memory): int
    {
        preg_match_all('/mul\((\d+),(\d+)\)/', $memory, $matches, PREG_SET_ORDER);
        
        return collect($matches)
            ->reduce(fn ($carry, $match)
                => $carry + $match[1] * $match[2], 0);
    }

    protected function parse(Input $input): string
    {
        return collect($input)
            ->map(fn($line) => $line)
            ->implode('');
    }
};