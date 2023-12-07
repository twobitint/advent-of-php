<?php

use twobitint\AdventOfPHP\Day;

return new class extends Day
{
    public function p1()
    {
        return $this->p(false);
    }

    public function p2()
    {
        return $this->p(true);
    }

    private function p($wilds): int
    {
        $hands = $this->hands();
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

    private function hands(): array
    {
        $hands = [];
        foreach (explode("\n", $this->input) as $line) {
            $hands[] = explode(' ', $line);
        }
        return $hands;
    }

    private function compare_hands(string $a, string $b, bool $wilds): int
    {
        $a_type = $this->hand_type($a, $wilds);
        $b_type = $this->hand_type($b, $wilds);
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

    // 0: High Card
    // 1: One Pair
    // 2: Two Pairs
    // 3: Three of a Kind
    // 4: Full House
    // 5: Four of a Kind
    // 6: Five of a Kind
    private function hand_type(string $hand, bool $wilds): int
    {
        $ranks = [];
        foreach (str_split($hand) as $card) {
            if (!isset($ranks[$card])) {
                $ranks[$card] = 0;
            }
            $ranks[$card]++;
        }

        if ($wilds && array_key_exists('J', $ranks)) {
            $jokers = $ranks['J'];
            unset($ranks['J']);
            if ($jokers == 4 || $jokers == 5) {
                return 6;
            } else if ($jokers == 3) {
                if (count($ranks) == 2) {
                    return 5;
                }
                return 6;
            } else if ($jokers == 2) {
                if (count($ranks) == 3) {
                    return 3;
                } else if (count($ranks) == 2) {
                    return 5;
                } else if (count($ranks) == 1) {
                    return 6;
                }
            } else if ($jokers == 1) {
                if (count($ranks) == 4) {
                    return 1;
                } else if (count($ranks) == 3) {
                    return 3;
                } else if (count($ranks) == 2) {
                    if (reset($ranks) == 2) {
                        return 4;
                    }
                    return 5;
                } else if (count($ranks) == 1) {
                    return 6;
                }
            }
        }

        if (count($ranks) == 1) {
            return 6;
        } else if (count($ranks) == 2) {
            foreach ($ranks as $rank => $count) {
                if ($count == 4) {
                    return 5;
                } else if ($count == 3) {
                    return 4;
                }
            }
        } else if (count($ranks) == 3) {
            foreach ($ranks as $rank => $count) {
                if ($count == 3) {
                    return 3;
                } else if ($count == 2) {
                    return 2;
                }
            }
        } else if (count($ranks) == 4) {
            return 1;
        } else {
            return 0;
        }
    }
};