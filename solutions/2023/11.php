<?php

use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;
use twobitint\AdventOfPHP\Util;

return new class extends Day {

    public function p1(Input $input): int
    {
        return $this->p($input, 1);
    }

    public function p2(Input $input): int
    {
        return $this->p($input, 999999);
    }

    protected function p(Input $input, int $multiplier): int
    {
        list($map, $expansions) = $this->parse($input);
        return $this->distances_between_galaxies($map, $expansions, $multiplier);
    }

    protected function expansions_down(array $map): array
    {
        $width = count($map[0]);
        $expansions = [];
        foreach ($map as $y => $line) {
            foreach ($line as $x => $char) {
                if ($char == '#') {
                    break;
                }
                if ($width - 1 == $x) {
                    $expansions[] = $y;
                }
            }
        }
        return $expansions;
    }

    protected function distances_between_galaxies(array $map, array $expansions, int $multiplier): int
    {
        $galaxies = [];
        for ($y = 0; $y < count($map); $y++) {
            for ($x = 0; $x < count($map[$y]); $x++) {
                if ($map[$y][$x] == '#') {
                    $galaxies[] = [$x, $y];
                }
            }
        }

        $distance = 0;
        $count = count($galaxies);
        for ($i = 0; $i < $count; $i++) {
            $galaxy = $galaxies[$i];
            foreach ($galaxies as $other) {
                if ($galaxy == $other) {
                    continue;
                }
                $distance += abs($galaxy[0] - $other[0]) + abs($galaxy[1] - $other[1]);
                $distance += $multiplier * $this->expansions_between($galaxy, $other, $expansions);
            }
            unset($galaxies[$i]);
        }

        return $distance;
    }

    protected function expansions_between(array $a, array $b, array $expansions): int
    {
        $count = 0;
        foreach ($expansions['x'] as $expansion) {
            if (($a[0] < $expansion && $expansion < $b[0]) || ($b[0] < $expansion && $expansion < $a[0])) {
                $count++;
            }
        }
        foreach ($expansions['y'] as $expansion) {
            if (($a[1] < $expansion && $expansion < $b[1]) || ($b[1] < $expansion && $expansion < $a[1])) {
                $count++;
            }
        }
        return $count;
    }

    protected function expand_down(array $original): array
    {
        $width = count($original[0]);
        $map = [];
        foreach ($original as $y => $line) {
            foreach ($line as $x => $char) {
                if ($char == '#') {
                    $map[] = $line;
                    break;
                }
                if ($width - 1 == $x) {
                    $map[] = $line;
                    $map[] = $line;
                }
            }
        }
        return $map;
    }

    protected function parse(Input $input): array
    {
        $map = [];
        foreach ($input as $y => $line) {
            foreach (str_split($line) as $x => $char) {
                $map[$y][$x] = $char;
            }
        }

        $expansions = [
            'x' => $this->expansions_down(Util::rotate_map_90($map)),
            'y' => $this->expansions_down($map),
        ];

        return [$map, $expansions];
    }
};