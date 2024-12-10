<?php

function p1(string $input): mixed
{
    $map = mapify($input);

    $scores = 0;
    for ($y = 0; $y < count($map); $y++) {
        for ($x = 0; $x < count($map[$y]); $x++) {
            if ($map[$y][$x] === '0') {
                $unique = [];
                score($map, $x, $y, $unique);
                $scores += count($unique);
            }
        }
    }
    return $scores;
}

function score($map, $x, $y, &$unique_nines): int
{
    $value = $map[$y][$x];
    
    if ($value == 9) {
        $unique_nines[] = "$x, $y";
        $unique_nines = array_unique($unique_nines);
        return 1;
    }

    $score = 0;
    $new_map = $map;
    $new_map[$y][$x] = '.';
    if (in_bounds($map, $x, $y + 1) && $new_map[$y + 1][$x] == $value + 1) {
        $score += score($new_map, $x, $y + 1, $unique_nines);
    }
    if (in_bounds($map, $x, $y - 1) && $new_map[$y - 1][$x] == $value + 1) {
        $score += score($new_map, $x, $y - 1, $unique_nines);
    }
    if (in_bounds($map, $x + 1, $y) && $new_map[$y][$x + 1] == $value + 1) {
        $score += score($new_map, $x + 1, $y, $unique_nines);
    }
    if (in_bounds($map, $x - 1, $y) && $new_map[$y][$x - 1] == $value + 1) {
        $score += score($new_map, $x - 1, $y, $unique_nines);
    }
    return $score;
}

function p2(string $input): mixed
{
    $map = mapify($input);

    $scores = 0;
    for ($y = 0; $y < count($map); $y++) {
        for ($x = 0; $x < count($map[$y]); $x++) {
            if ($map[$y][$x] === '0') {
                $unique = [];
                $scores += score($map, $x, $y, $unique);
            }
        }
    }
    return $scores;
}