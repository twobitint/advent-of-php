<?php

function p1(string $input): mixed
{
    $disk = input_to_disk($input);
    compress_p1($disk);
    return checksum($disk);
}

function p2(string $input): mixed
{
    $disk = input_to_disk($input);
    compress_p2($disk);
    return checksum($disk);
}

function checksum(array $disk): int
{
    $sum = 0;
    for ($i = 0; $i < count($disk); $i++) {
        if ($disk[$i] === null) {
            continue;
        }
        $sum += $disk[$i] * $i;
    }
    return $sum;
}

function compress_p2(array &$disk): void
{
    $last = $disk[count($disk) - 1] + 1;
    for ($i = count($disk) - 1; $i >= 0; $i--) {
        $block = $disk[$i];
        if ($block >= $last || $block === null) {
            continue;
        }
        $last = $block;
        $size = get_block_size($disk, $i);
        $f = first_free($disk, $size);
        if ($f === false || $f >= $i) {
            continue;
        }
        for ($j = 0; $j < $size; $j++) {
            $disk[$f + $j] = $disk[$i - $j];
            $disk[$i - $j] = null;
        }
    }
}

function get_block_size($disk, $i): int
{
    $size = 1;
    while ($i > 0 && $disk[$i] === $disk[$i - 1]) {
        $size++;
        $i--;
    }
    return $size;
}

function compress_p1(array &$disk): void
{
    for ($i = count($disk) - 1; $i >= 0; $i--) {
        if ($disk[$i] === null) {
            continue;
        }
        $f = first_free($disk, 1);
        if ($f >= $i) {
            return;
        }
        $disk[$f] = $disk[$i];
        $disk[$i] = null;
    }
}

function first_free(array $disk, int $size): mixed
{
    if ($size == 1) {
        return array_search(null, $disk, true);
    }

    $free_count = 0;
    for ($i = 0; $i < count($disk); $i++) {
        if ($disk[$i] === null) {
            $free_count++;
        } else {
            $free_count = 0;
        }
        if ($free_count === $size) {
            return $i - $size + 1;
        }
    }
    return false;
}

function input_to_disk(string $input): array
{
    $data = str_split($input);
    $disk = [];
    $file_id = 0;
    for ($i = 0; $i < count($data); $i++) {
        if ($i % 2 === 0) {
            for ($b = 0; $b < $data[$i]; $b++) {
                $disk[] = $file_id;
            }
            $file_id++;
        } else {
            for ($b = 0; $b < $data[$i]; $b++) {
                $disk[] = null;
            }
        }
    }
    return $disk;
}