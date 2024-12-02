<?php

use Illuminate\Support\Collection;
use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;

return new class extends Day {

    public function p1(Input $input): int
    {
        return $this->parse($input)
            ->filter(fn ($line) => $this->safe($line))
            ->count();
    }

    public function p2(Input $input): int
    {
        return $this->parse($input)
            ->filter(fn ($line) => $this->canBeSafe($line))
            ->count();
    }

    protected function canBeSafe($line): bool
    {
        if ($this->safe($line)) {
            return true;
        }

        for ($i = 0; $i < count($line); $i++) {
            $copy = $line;
            array_splice($copy, $i, 1);
            if ($this->safe($copy)) {
                return true;
            }
        }

        return false;
    }

    protected function safe($line): bool
    {
        $increasing = $line[0] < $line[1];
        for ($i = 0; $i < count($line) - 1; $i++) {
            $diff = $line[$i + 1] - $line[$i];
            if ($increasing && $diff <= 0) {
                break;
            }
            if (!$increasing && $diff >= 0) {
                break;
            }
            if ($diff > 3 || $diff < -3) {
                break;
            }
            if ($i === count($line) - 2) {
                return true;
            }
        }
        return false;
    }

    protected function parse(Input $input): Collection
    {
        return collect($input)
            ->map(fn($line) => explode(' ', $line));
    }
};