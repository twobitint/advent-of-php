<?php

use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;

return new class extends Day
{
    public function p1(Input $input): int
    {
        return $this->p($input, false);
    }

    public function p2(Input $input): int
    {
        return $this->p($input, true);
    }

    private function p(Input $input, $wilds): int
    {
        $hands = $this->hands($input);
        usort($hands, fn ($b, $a) => $this->compare_hands($a[0], $b[0], $wilds));
        return $this->score($hands);
    }

    private function score(array $hands): int
    {
        $total = 0;
        for ($i = 0; $i < count($hands); $i++) {
            $total += ($i + 1) * $hands[$i][1];
        }
        return $total;
    }

    private function hands(Input $input): array
    {
        $hands = [];
        foreach ($input->lines() as $line) {
            $hands[] = explode(' ', $line);
        }
        return $hands;
    }

    private function compare_hands(string $a, string $b, bool $wilds): int
    {
        $a_type = $this->hand_score($a, $wilds);
        $b_type = $this->hand_score($b, $wilds);
        if ($a_type == $b_type) {
            for ($i = 0; $i < 5; $i++) {
                if ($a[$i] != $b[$i]) {
                    $ai = str_replace(['T', 'J', 'Q', 'K', 'A'], [10, $wilds ? 1 : 11, 12, 13, 14], $a[$i]);
                    $bi = str_replace(['T', 'J', 'Q', 'K', 'A'], [10, $wilds ? 1 : 11, 12, 13, 14], $b[$i]);
                    return $bi <=> $ai;
                }
            }
        } else {
            return $b_type <=> $a_type;
        }
    }

    private function hand_score(string $hand, bool $wilds): int
    {
        $ranks = [];
        foreach (str_split($hand) as $card) {
            if (!isset($ranks[$card])) {
                $ranks[$card] = 0;
            }
            $ranks[$card]++;
        }

        $jokers = 0;
        if ($wilds && array_key_exists('J', $ranks)) {
            $jokers = $ranks['J'];
            if ($jokers == 5) {
                return 4;
            }
            unset($ranks['J']);
        }

        return max($ranks) + $jokers - count($ranks);
    }
};