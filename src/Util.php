<?php

namespace twobitint\AdventOfPHP;

use Symfony\Component\Console\Output\Output;

class Util {
    public static function print_map(array $map, Output $output): void
    {
        foreach ($map as $line) {
            $write = '';
            foreach ($line as $char) {
                $write .= $char;
            }
            $output->writeln($write);
        }
    }

    public static function rotate_map_90($map)
    {
        $map = array_values($map);
        $map90 = array();
    
        // make each new row = reversed old column
        foreach(array_keys($map[0]) as $column) {
            $map90[] = array_reverse(array_column($map, $column));
        }
    
        return $map90;
    }
}