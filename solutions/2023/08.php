<?php

use twobitint\AdventOfPHP\Day;
use twobitint\AdventOfPHP\Input;

return new class extends Day {

    public function p1(Input $input): int
    {
        list($instructions, $network_string) = explode("\n\n", $input);
        $network = $this->network($network_string);
        return $this->steps($network, $instructions, 'AAA', 'ZZZ');
    }

    public function p2(Input $input): int
    {
        list($instructions, $network_string) = explode("\n\n", $input);

        $network = $this->network($network_string);

        $lcm = 1;
        foreach (array_keys($network) as $label) {
            if ($label[2] == 'A') {
                $lcm = gmp_lcm($lcm, $this->steps($network, $instructions, $label));
            }
        }

        return (int)$lcm;
    }

    protected function steps(array $network, string $instructions, string $start): int
    {
        $steps = 0;
        while ($start[2] != 'Z') {
            $index = $steps % strlen($instructions);
            if ($instructions[$index] == 'L') {
                $start = $network[$start]['left'];
            } else {
                $start = $network[$start]['right'];
            }
            $steps++;
        }

        return $steps;
    }

    protected function network(string $network_string): array
    {
        $network = [];
        preg_match_all('/([1-9A-Z]+) = \(([1-9A-Z]+), ([1-9A-Z]+)\)/', $network_string, $matches);
        for ($i = 0; $i < count($matches[0]); $i++) {
            $network[$matches[1][$i]] = [
                'left' => $matches[2][$i],
                'right' => $matches[3][$i],
            ];
        }
        return $network;
    }
};