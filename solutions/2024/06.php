<?php

const EXITED = 0;
const MOVE_OK = 1;
const LOOP_DETECTED = 2;

function p1(string $input): mixed
{
    $map = mapify($input);

    [$x, $y] = find_starting_point($map);

    simulate($map, $x, $y);

    return count_distinct_visited_spaces($map);
}

function p2(string $input): mixed
{
    $map = mapify($input);
    $p1_map = $map;

    [$x, $y] = find_starting_point($map);
    simulate($p1_map, $x, $y);
    $path_coords = find_path_coords($p1_map);

    $count = 0;
    foreach ($path_coords as [$i, $j]) {
        // $i = 98; $j = 5;
        if ($i === $x && $j === $y) {
            continue;
        }
        $new_map = $map;
        $new_map[$j][$i] = '#';
        // echo "Simulating $i, $j\n";
        if (! simulate($new_map, $x, $y)) {
            $count++;
        }
    }

    return $count;
}

function find_path_coords($map): array
{
    $coords = [];
    for ($y = 0; $y < count($map); $y++) {
        for ($x = 0; $x < count($map[$y]); $x++) {
            if ($map[$y][$x] === '^' || $map[$y][$x] === '>' || $map[$y][$x] === 'v' || $map[$y][$x] === '<') {
                $coords[] = [$x, $y];
            }
        }
    }
    return $coords;
}

function simulate(array &$map, int $x, int $y): bool
{
    $visited = [];
    while (true) {
        // animate_frame(function () use ($map, $x, $y) {
        //     print_map($map, [$x, $y], 10);
        // }, 0.3);
        $dir = match ($map[$y][$x]) {
            '^' => [0, -1],
            '>' => [1, 0],
            'v' => [0, 1],
            '<' => [-1, 0],
        };
        $result = move($map, $x, $y, $dir, $visited);

        if ($result === EXITED) {
            return true;
        } else if ($result === LOOP_DETECTED) {
            return false;
        }
    }
}

function move(array &$map, int &$x, int &$y, array $dir, array &$visited = []): int
{
    $last_x = $x;
    $last_y = $y;
    $x += $dir[0];
    $y += $dir[1];

    if (! in_bounds($map, $x, $y)) {
        return EXITED;
    } else if ($map[$y][$x] == '#') {
        $x = $last_x;
        $y = $last_y;
        $map[$y][$x] = match ($dir) {
            [0, -1] => '>',
            [1, 0] => 'v',
            [0, 1] => '<',
            [-1, 0] => '^',
        };

        if (isset($visited[$y][$x]) && 
            ($visited[$y][$x][0] === $map[$y][$x] || ($visited[$y][$x][1] ?? null) === $map[$y][$x])) {
            return LOOP_DETECTED;
        } else {
            $visited[$y][$x][] = $map[$y][$x];
            // clear_console();
            // var_dump($visited);
            // usleep(1000000);
        }
    } else {
        $map[$y][$x] = $map[$last_y][$last_x];
    }
    return MOVE_OK;
}

function count_distinct_visited_spaces($map): int
{
    $count = 0;
    foreach ($map as $row) {
        foreach ($row as $cell) {
            if ($cell === '^' || $cell === '>' || $cell === 'v' || $cell === '<') {
                $count++;
            }
        }
    }
    return $count;
}

function find_starting_point($map): array
{
    foreach ($map as $y => $row) {
        foreach ($row as $x => $cell) {
            if ($cell === '^') {
                return [$x, $y];
            }
        }
    }
    return [-1, -1];
}