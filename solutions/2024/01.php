<?php

use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;

return new class extends Day {

    public function p1(Input $input): int
    {
        $data = $this->parse($input);
        sort($data['left']);
        sort($data['right']);

        $distance = 0;
        for ($i = 0; $i < count($data['left']); $i++) {
            $distance += abs($data['left'][$i] - $data['right'][$i]);
        }

        return $distance;
    }

    public function p2(Input $input): int
    {
        $data = $this->parse($input);
        $counts = [];
        foreach ($data['right'] as $r) {
            $counts[$r] = ($counts[$r] ?? 0) + 1;
        }

        $similarity = 0;
        foreach ($data['left'] as $l) {
            if (isset($counts[$l])) {
                $similarity += $counts[$l] * $l;
            }
        }

        return $similarity;
    }

    protected function parse(Input $input): array
    {
        $left = [];
        $right = [];
        foreach ($input as $line) {
            [$l, $r] = preg_split('/\s+/', $line);
            $left[] = $l;
            $right[] = $r;
        }

        return [
            'left' => $left,
            'right' => $right,
        ];
    }
};