<?php

use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;

return new class extends Day {

    public function p1(Input $input): int
    {
        return count($this->main_loop($input)[1]) / 2;
    }

    public function p2(Input $input): int
    {
        $S_char = '|';
        list($map, $main_loop) = $this->main_loop($input);

        $count = 0;

        for($y = 0; $y < count($map); $y++) {
            $write = "";
            $intersections = 0;
            $open_up = false;
            $open_down = false;
            for ($x = 0; $x < count($map[$y]); $x++) {
                $pos = $map[$y][$x];
                if ($pos == 'S') {
                    $pos = $S_char;
                }
                if (in_array([$x, $y], $main_loop)) {
                    if ($pos == '|') {
                        $intersections++;
                    }
                    if ($pos == '7') {
                        if ($open_up) {
                            $intersections++;
                            $open_up = false;
                        }
                        $open_down = false;
                    }
                    if ($pos == 'F') {
                        $open_down = true;
                    }
                    if ($pos == 'L') {
                        $open_up = true;
                    }
                    if ($pos == 'J') {
                        if ($open_down) {
                            $intersections++;
                            $open_down = false;
                        }
                        $open_up = false;
                    }

                    if ($x == 63 && $y == 63) {
                        $write .= "<fg=yellow>$pos</>";
                    } else {
                        $write .= $pos;
                    }
                } else if ($intersections % 2 == 1) {
                    $count++;
                    $write .= "<fg=green>I</>";
                } else {
                    $write .= "<fg=red>0</>";  
                }
            }
            // $this->output->writeln($write);
        }

        return $count;
    }

    protected function main_loop(Input $input): array
    {
        $main_loop = [];
        $map = [];
        $start_x = 0;
        $start_y = 0;
        $x = 0;
        $y = 0;
        foreach ($input as $line) {
            foreach (str_split($line) as $x => $char) {
                $map[$y][$x] = $char;
                if ($char === 'S') {
                    $start_x = $x;
                    $start_y = $y;
                }
            }
            $y++;
        }

        $from_x = $start_x;
        $from_y = $start_y;
        $x = $start_x;
        $y = $start_y + 1;
        $main_loop[] = [$start_x, $start_y];
        $count = 1;
        while ($x != $start_x || $y != $start_y) {
            $count++;
            $current = $map[$y][$x];
            $main_loop[] = [$x, $y];
            $new_x = $x;
            $new_y = $y;
            switch ($current) {
                case '-':
                    $new_x += $x - $from_x;
                    break;
                case '|':
                    $new_y += $y - $from_y;
                    break;
                case 'F':
                case '7':
                    if ($from_y == $y) {
                        $new_y++;
                    } else if ($current == '7') {
                        $new_x--;
                    } else {
                        $new_x++;
                    }
                    break;
                case 'L':
                case 'J':
                    if ($from_y == $y) {
                        $new_y--;
                    } else if ($current == 'J') {
                        $new_x--;
                    } else {
                        $new_x++;
                    }
                    break;
            }
            $from_x = $x;
            $from_y = $y;
            $x = $new_x;
            $y = $new_y;
        }

        return [$map, $main_loop];
    }
};