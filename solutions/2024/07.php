<?php

function p1(string $input): mixed
{
    return collect(explode("\n", $input))
        ->filter(fn ($line) => test_equation($line))
        ->sum(fn ($line) => get_sides($line)[0]);
}

function p2(string $input): mixed
{
    return collect(explode("\n", $input))
        ->filter(fn ($line) => test_equation($line, true))
        ->sum(fn ($line) => get_sides($line)[0]);
}

function test_equation(string $line, bool $use_concat = false): bool
{
    [$lhs, $rhs] = get_sides($line);

    if (count ($rhs) === 1) {
        return $lhs == $rhs[0];
    }

    $sum = $rhs[0] + $rhs[1];
    if ($sum <= $lhs) {
        $new_rhs = array_slice($rhs, 1);
        $new_rhs[0] = $sum;
        $summed_result = test_equation("$lhs: " . implode(' ', $new_rhs), $use_concat);
    }

    $product = $rhs[0] * $rhs[1];
    if ($product <= $lhs) {
        $new_rhs = array_slice($rhs, 1);
        $new_rhs[0] = $product;
        $product_result = test_equation("$lhs: " . implode(' ', $new_rhs), $use_concat);
    }

    if ($use_concat) {
        $concat = $rhs[0] . $rhs[1];
        if ($concat <= $lhs) {
            $new_rhs = array_slice($rhs, 1);
            $new_rhs[0] = $concat;
            $concat_result = test_equation("$lhs: " . implode(' ', $new_rhs), $use_concat);
        }
    }

    return ($summed_result ?? false)
        || ($product_result ?? false)
        || ($concat_result ?? false);
}

function get_sides(string $line): array
{
    [$lhs, $rhs] = explode(': ', $line);
    $rhs = explode(' ', $rhs);
    return [(int) $lhs, $rhs];
}