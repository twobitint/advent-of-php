<?php

function mapify(string $input): array
{
    $map = [];
    $lines = explode("\n", $input);
    foreach ($lines as $line) {
        $map[] = str_split($line);
    }
    return $map;
}

function map_iter(array $map, Callable $callback): void
{
    for ($y = 0; $y < count($map); $y++) {
        for ($x = 0; $x < count($map[$y]); $x++) {
            $callback($map[$y][$x], $x, $y);
        }
    }
}

function print_map(array $map, array $center = null, int $dist = null): void
{
    if (! $center) {
        $center = [floor(count($map[0]) / 2), floor(count($map) / 2)];
    }

    if (! $dist) {
        $dist = max($center[0], $center[1]);
    }

    foreach (array_slice($map, $center[1] - $dist, $dist * 2 + 1) as $line) {
        $write = '';
        foreach (array_slice($line, $center[0] - $dist, $dist * 2 + 1) as $char) {
            $write .= $char;
        }
        echo $write . "\n";
    }
    echo "\n";
}

function in_bounds(array $map, int $x, int $y): bool
{
    return $x >= 0 && $y >= 0 && $x < count($map[0]) && $y < count($map);
}

function clear_console(): void
{
    echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
}

function animate_frame(Callable $callback, $wait = 0.2): void
{
    clear_console();
    $callback();
    usleep($wait * 1000000);
}