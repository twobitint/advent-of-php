<?php

use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;
use twobitint\AdventOfPHP\Util;

return new class extends Day {

    public function p1(Input $input): int
    {
        foreach (explode("\n\n", $input) as $chunk) {
            $lines = explode("\n", $chunk);
            $mirror = [];
            $y = 1;
            foreach ($lines as $line) {
                if (empty($mirror)) {
                    $mirror[] = $line;
                    continue;
                }
            }
            Util::rotate_string_90($chunk);
        }
        return 0;
    }

    public function p2(Input $input): int
    {
        return 0;
    }

    protected function parse(Input $input): array
    {
        return [];
    }
};