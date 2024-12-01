<?php

use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;

return new class extends Day {

    public function p1(Input $input): int
    {
        $count = 0;
        foreach ($input as $line) {
            list($record, $damaged_spring_sizes) = $this->parse_line($line);
            $count += $this->arrangements($record, $damaged_spring_sizes);
        }
        return 0;
    }

    public function p2(Input $input): int
    {
        return 0;
    }

    protected function arrangements(string $record, array $damaged_spring_sizes): int
    {
        $count = 0;
        foreach ($damaged_spring_sizes as $size) {
            $count += $this->arrangements($record, $damaged_spring_sizes);
        }


        return $arrangements;
    }

    protected function parse_line(string $line): array
    {
        list($record, $spring_string) = explode(' ', $line);
        preg_match_all('/\d+/', $spring_string, $matches);
        return [$record, $matches[0]];
    }
};