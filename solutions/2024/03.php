<?php

use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;

return new class extends Day {

    public function p1(Input $input): int
    {
        return $this->calculate($input);
    }

    public function p2(Input $input): int
    {
        return $this->calculate($input, false);
    }

    protected function calculate(Input $input, bool $always_enabled = true): int
    {
        $memory = collect($input)->implode('');

        preg_match_all('/mul\((\d+),(\d+)\)|do\(\)|don\'t\(\)/', $memory, $matches, PREG_SET_ORDER);

        return collect($matches)
            ->reduce(function ($carry, $match) use ($always_enabled, &$enabled) {
                if ($match[0] == 'do()') {
                    $enabled = true;
                } else if ($match[0] == 'don\'t()') {
                    $enabled = false;
                } else if ($always_enabled || !isset($enabled) || $enabled) {
                    $carry += $match[1] * $match[2];
                }
                return $carry;
            }, 0);
    }
};