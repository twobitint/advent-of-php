<?php

use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;

return new class extends Day {

    public function p1(Input $input): int
    {
        return $this->p($input, false);
    }

    public function p2(Input $input): int
    {
        return $this->p($input, true);
    }

    protected function p(Input $input, bool $reverse): int
    {
        $sum = 0;
        foreach ($this->parse($input) as $line) {
            $sum += $this->nextValue($reverse ? array_reverse($line) : $line);
        }
        return $sum;
    }

    protected function nextValue(array $line): int
    {
        if ($this->all_zeroes($line)) {
            return 0;
        }

        $diffs = [];
        for ($i = 0; $i < count($line) - 1; $i++) {
            $diffs[] = $line[$i + 1] - $line[$i];
        }

        return $this->nextValue($diffs) + $line[$i];
    }

    protected function all_zeroes(array $line): bool
    {
        foreach ($line as $i) {
            if ($i != 0) {
                return false;
            }
        }
        return true;
    }

    protected function parse(Input $input): array
    {
        $lines = [];
        foreach ($input->lines() as $line) {
            preg_match_all('/[\-0-9]+/', $line, $matches);
            $lines[] = $matches[0];
        }
        return $lines;
    }
};