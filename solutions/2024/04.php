<?php

use Illuminate\Support\Collection;
use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;

return new class extends Day {

    public function p1(Input $input): int
    {
        error_reporting(E_ERROR);

        $total = 0;
        $puzzle = $this->parse($input);
        for ($y = 0; $y < count($puzzle); $y++) {
            for ($x = 0; $x < count($puzzle[$y]); $x++) {
                $total += $this->startsXMAS($puzzle, $x, $y);
            }
        }
        return $total;
    }

    public function p2(Input $input): int
    {
        error_reporting(E_ERROR);
        
        $total = 0;
        $puzzle = $this->parse($input);
        for ($y = 0; $y < count($puzzle); $y++) {
            for ($x = 0; $x < count($puzzle[$y]); $x++) {
                $total += $this->startsTwoMAS($puzzle, $x, $y);
            }
        }
        return $total;
    }

    private function startsTwoMAS($puzzle, $x, $y): int
    {
        if ($puzzle[$y][$x] !== 'A') {
            return 0;
        }

        $total = $puzzle[$y + 1][$x + 1] === 'M'
            && $puzzle[$y - 1][$x - 1] === 'S'
            && $puzzle[$y + 1][$x - 1] === 'M'
            && $puzzle[$y - 1][$x + 1] === 'S';

        $total += $puzzle[$y + 1][$x + 1] === 'M'
            && $puzzle[$y - 1][$x - 1] === 'S'
            && $puzzle[$y + 1][$x - 1] === 'S'
            && $puzzle[$y - 1][$x + 1] === 'M';

        $total += $puzzle[$y + 1][$x + 1] === 'S'
            && $puzzle[$y - 1][$x - 1] === 'M'
            && $puzzle[$y + 1][$x - 1] === 'M'
            && $puzzle[$y - 1][$x + 1] === 'S';

        $total += $puzzle[$y + 1][$x + 1] === 'S'
            && $puzzle[$y - 1][$x - 1] === 'M'
            && $puzzle[$y + 1][$x - 1] === 'S'
            && $puzzle[$y - 1][$x + 1] === 'M';

        return $total;
    }

    private function startsXMAS(Collection $puzzle, int $x, int $y): int
    {
        if ($puzzle[$y][$x] !== 'X') {
            return 0;
        }

        $total = $puzzle[$y][$x + 1] === 'M'
            && $puzzle[$y][$x + 2] === 'A'
            && $puzzle[$y][$x + 3] === 'S';

        $total += $puzzle[$y][$x - 1] === 'M'
            && $puzzle[$y][$x - 2] === 'A'
            && $puzzle[$y][$x - 3] === 'S';

        $total += $puzzle[$y + 1][$x] === 'M'
            && $puzzle[$y + 2][$x] === 'A'
            && $puzzle[$y + 3][$x] === 'S';

        $total += $puzzle[$y - 1][$x] === 'M'
            && $puzzle[$y - 2][$x] === 'A'
            && $puzzle[$y - 3][$x] === 'S';

        $total += $puzzle[$y - 1][$x - 1] === 'M'
            && $puzzle[$y - 2][$x - 2] === 'A'
            && $puzzle[$y - 3][$x - 3] === 'S';

        $total += $puzzle[$y - 1][$x + 1] === 'M'
            && $puzzle[$y - 2][$x + 2] === 'A'
            && $puzzle[$y - 3][$x + 3] === 'S';

        $total += $puzzle[$y + 1][$x - 1] === 'M'
            && $puzzle[$y + 2][$x - 2] === 'A'
            && $puzzle[$y + 3][$x - 3] === 'S';

        $total += $puzzle[$y + 1][$x + 1] === 'M'
            && $puzzle[$y + 2][$x + 2] === 'A'
            && $puzzle[$y + 3][$x + 3] === 'S';

        return $total;    
    }

    private function parse(Input $input): Collection
    {
        return collect($input)->map(fn ($line) => collect(str_split($line)));
    }
};