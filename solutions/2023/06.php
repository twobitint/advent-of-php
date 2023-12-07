<?php

use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;

return new class extends Day
{
    public function p1(Input $input): int
    {
        list($time_string, $dist_string) = explode("\n", $input);
        preg_match_all('/\d+/', $time_string, $matches);
        $times = $matches[0];
        preg_match_all('/\d+/', $dist_string, $matches);
        $dists = $matches[0];

        $solution = 1;
        for ($i = 0; $i < count($times); $i++) {
            $perms = 0;
            $time = $times[$i];
            $dist = $dists[$i];
            for ($hold = 0; $hold <= $time; $hold++) {
                $remaining = $time - $hold;
                $travels = $remaining * $hold;
                if ($travels > $dist) {
                    $perms++;
                }
            }
            $solution *= $perms;
        }

        return $solution;
    }

    public function p2(Input $input): int
    {
        $input = new Input(str_replace(' ', '', $input));
        return $this->p1($input);
    }
};
