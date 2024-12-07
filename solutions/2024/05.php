<?php

use Illuminate\Support\Collection;

function p1(string $input): mixed
{
    parse($input, $rules, $updates);

    $total = 0;
    $updates->each(function ($update) use ($rules, &$total) {
        is_valid($update, $rules)
            && $total += middle($update);
    });

    return $total;
}

function p2(string $input): mixed
{
    parse($input, $rules, $updates);

    $total = 0;
    $updates->each(function ($update) use ($rules, &$total) {
        !is_valid($update, $rules)
            && $total += middle(fix($update, $rules));
    });

    return $total;
}

function fix(Collection $update, Collection $rules): Collection
{
    return $update->sort(function ($a, $b) use ($rules) {
        if ($rules->has($a) && $rules[$a]->contains($b)) {
            return -1;
        } else if ($rules->has($b) && $rules[$b]->contains($a)) {
            return 1;
        }
        return 0;
    })->values();
}

function middle(Collection $update): int
{
    return $update[floor(count($update) / 2)];
}

function parse(string $input, ?Collection &$rules, ?Collection &$updates): void
{
    [$top, $bottom] = explode("\n\n", $input);
    $rules = collect();
    $updates = collect();
    
    preg_match_all('/(\d+)\|(\d+)/', $top, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
        if (!isset($rules[$match[1]])) {
            $rules[$match[1]] = collect();
        }
        $rules[$match[1]]->push($match[2]);
    }

    foreach (explode("\n", $bottom) as $line) {
        $updates[] = collect(explode(',', $line));
    }
}

function is_valid(Collection $update, Collection $rules): bool
{
    for ($i = 0; $i < count($update); $i++) {
        $left_page = $update[$i];
        if ($page_rules = $rules[$left_page] ?? null) {
            foreach ($page_rules as $right_page) {
                // If the right_page is found to the left of the left_page,
                // the update is invalid.
                for ($j = 0; $j < $i; $j++) {
                    if ($update[$j] == $right_page) {
                        return false;
                    }
                }
            }
        }
    }
    return true;
}