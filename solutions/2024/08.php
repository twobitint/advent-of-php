<?php

function p1(string $input): mixed
{
    $map = mapify($input);

    map_iter($map, function ($char, $x, $y) use (&$antennas) {
        if ($char != '.' && $char != '#') {
            $antennas[$char][] = [$x, $y];
        }
    });

    $antinodes = antinodes_p1($map, $antennas);

    return collect($antinodes)->unique()->count();
}

function p2(string $input): mixed
{
    $map = mapify($input);

    map_iter($map, function ($char, $x, $y) use (&$antennas) {
        if ($char != '.' && $char != '#') {
            $antennas[$char][] = [$x, $y];
        }
    });

    $antinodes = antinodes_p2($map, $antennas);

    return count($antinodes);
}

function antinodes_p2($map, $antennas): array
{
    $antinodes = [];
    foreach ($antennas as $freq) {
        foreach ($freq as $coord1) {
            foreach ($freq as $coord2) {
                if ($coord1 === $coord2) {
                    continue;
                }
                $diffx = $coord2[0] - $coord1[0];
                $diffy = $coord2[1] - $coord1[1];
                $i = 1;
                while (true) {
                    $ax = $coord1[0] + $diffx * $i;
                    $ay = $coord1[1] + $diffy * $i;
                    if (! in_bounds($map, $ax, $ay)) {
                        break;
                    }
                    $antinodes["$ay,$ax"] = true;
                    $i++;
                }
                $i = 1;
                while (true) {
                    $ax = $coord2[0] - $diffx * $i;
                    $ay = $coord2[1] - $diffy * $i;
                    if (! in_bounds($map, $ax, $ay)) {
                        break;
                    }
                    $antinodes["$ay,$ax"] = true;
                    $i++;
                }
            }
        }
    }
    return $antinodes;
}

function antinodes_p1($map, $antennas): array
{
    $antinodes = [];
    foreach ($antennas as $freq) {
        foreach ($freq as $coord1) {
            foreach ($freq as $coord2) {
                if ($coord1 === $coord2) {
                    continue;
                }
                $diffx = $coord2[0] - $coord1[0];
                $diffy = $coord2[1] - $coord1[1];
                $a1x = $coord1[0] + $diffx;
                $a1y = $coord1[1] + $diffy;
                if ($a1x == $coord2[0] && $a1y == $coord2[1]) {
                    $a1x = $coord1[0] - $diffx;
                    $a1y = $coord1[1] - $diffy;
                    $a2x = $coord2[0] + $diffx;
                    $a2y = $coord2[1] + $diffy;
                } else {
                    $a2x = $coord2[0] - $diffx;
                    $a2y = $coord2[1] - $diffy;
                }

                if (in_bounds($map, $a1x, $a1y)) {
                    $antinodes[] = [$a1x, $a1y];
                }
                if (in_bounds($map, $a2x, $a2y)) {
                    $antinodes[] = [$a2x, $a2y];
                }
            }
        }
    }
    return $antinodes;
}