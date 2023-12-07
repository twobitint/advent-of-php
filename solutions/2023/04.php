<?php

use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;

return new class extends Day
{
    public function p1(Input $input): int
    {
        $answer = 0;
        foreach ($input->lines() as $line) {
            list(, $data) = explode(':', $line);
            list($winners, $picks) = explode("|", $data);
            $winners_list = preg_split('/\s+/', $winners, -1, PREG_SPLIT_NO_EMPTY);
            $picks = preg_split('/\s+/', $picks, -1, PREG_SPLIT_NO_EMPTY);
            $winners = [];
            foreach ($winners_list as $winner) {
                $winners[$winner] = true;
            }

            $correct = 0;
            foreach ($picks as $pick) {
                if (isset($winners[$pick])) {
                    $correct++;
                }
            }
            if ($correct > 0) {
                $score = pow(2, $correct - 1);
                $answer += $score;
            }
        }

        return $answer;
    }

    public function p2(Input $input): int
    {
        $answer = 0;
        $n = 0;
        $number_of_cards = [1];
        foreach ($input->lines() as $line) {
            $multiplier = $number_of_cards[$n] ?? 1;
            $answer += $multiplier;

            list(, $data) = explode(':', $line);
            list($winners, $picks) = explode("|", $data);
            $winners_list = preg_split('/\s+/', $winners, -1, PREG_SPLIT_NO_EMPTY);
            $picks = preg_split('/\s+/', $picks, -1, PREG_SPLIT_NO_EMPTY);
            $winners = [];
            foreach ($winners_list as $winner) {
                $winners[$winner] = true;
            }

            $correct = 0;
            foreach ($picks as $pick) {
                if (isset($winners[$pick])) {
                    $correct++;
                }
            }
            for ($i = 1; $i <= $correct; $i++) {
                if (!isset($number_of_cards[$n + $i])) {
                    $number_of_cards[$n + $i] = $multiplier + 1;
                } else {
                    $number_of_cards[$n + $i] += $multiplier;
                }
            }
            $n++;
        }
        return $answer;
    }
};