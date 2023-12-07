<?php

use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;

return new class extends Day
{

    public function p2(Input $input): int
    {
        $parts = [];
        $gears = [];
        $y = 0;
        foreach ($input->lines() as $line) {
            preg_match_all('/\*/', $line, $gear_matches, PREG_OFFSET_CAPTURE);
            preg_match_all('/\d+/', $line, $part_matches, PREG_OFFSET_CAPTURE);

            foreach ($gear_matches[0] as $match) {
                $gears[] = [
                    'x' => $match[1],
                    'y' => $y,
                ];
            }

            foreach ($part_matches[0] as $match) {
                $parts[] = [
                    'part' => $match[0],
                    'x0' => $match[1],
                    'x1' => $match[1] + strlen($match[0]) - 1, 
                    'y' => $y,
                ];
            }

            $y++;
        }

        $solution = 0;
        foreach ($gears as $gear) {
            $adjacents = [];
            foreach ($parts as $part) {
                if ($this->gear_adjacent_to_part($gear, $part)) {
                    $adjacents[] = $part['part'];
                }
            }
            if (count($adjacents) == 2) {
                $solution += $adjacents[0] * $adjacents[1];
            }
        }

        return $solution;
    }

    private function gear_adjacent_to_part($gear, $part): bool
    {
        $x = $gear['x'];
        $y = $gear['y'];
        if ($part['y'] == $y || $part['y'] + 1 == $y || $part['y'] - 1 == $y) {
            if (!($part['x0'] > $x + 1 || $part['x1'] < $x - 1)) {
                return true;
            }
        }

        return false;
    }

};