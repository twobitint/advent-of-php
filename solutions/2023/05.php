<?php

use twobitint\AdventOfPHP\Day;

return new class extends Day
{
    private array $map;

    public function p1()
    {
        list($seed_string, $map_strings) = explode("\n\n", $this->input, 2);
        preg_match_all('/\d+/', $seed_string, $seeds);
        $seeds = $seeds[0];

        $this->buildMap($map_strings);
        return $this->findLowest($seeds);
    }

    public function p2()
    {
        list($seed_string, $map_strings) = explode("\n\n", $this->input, 2);
        preg_match_all('/\d+/', $seed_string, $seeds);
        $seeds = $seeds[0];

        $this->buildMap($map_strings);

        $n = 0;
        while (true) {
            $dest = $n;
            $category = 'location';
            while ($category != 'seed') {
                $next = $this->getReverseCategory($category);
                $dest = $this->reverselookup($category, $next, $dest);
                $category = $next;
            }
            if ($this->isSeed($seeds, $dest)) {
                return $n;
            }
            $n++;
        }
    }

    private function isSeed(array $seeds, $value): bool
    {
        for ($i = 0; $i < count($seeds) / 2; $i++) {
            $start = $seeds[$i * 2];
            $end = $start + $seeds[$i * 2 + 1];
            if ($value >= $start && $value <= $end) {
                return true;
            }
        }
        return false;
    }

    private function reverselookup($from, $to, $source): int
    {
        foreach ($this->map[$to][$from] as $map) {
            $offset = $source - $map['dest'];
            if ($offset >= 0 && $offset <= $map['range']) {
                return $map['source'] + $offset;
            }
        }
        return $source;
    }

    private function findLowest($seeds): int
    {
        $lowest = 999999999;
        foreach ($seeds as $dest) {
            $category = 'seed';
            while ($category != 'location') {
                $next = $this->getNextCategory($category);
                $dest = $this->lookup($category, $next, $dest);
                $category = $next;
            }
            if ($dest < $lowest) {
                $lowest = $dest;
            }
        }
        return $lowest;
    }

    private function buildMap($map_strings): void
    {
        $this->map = [];
        foreach (explode("\n\n", $map_strings) as $map_string) {
            list($name_string, $map_string) = explode("\n", $map_string, 2);
            preg_match('/([a-z]+)-to-([a-z]+)/', $name_string, $name_matches);
            list(, $from, $to) = $name_matches;

            foreach (explode("\n", $map_string) as $map_string_chunk) {
                preg_match('/(\d+) (\d+) (\d+)/', $map_string_chunk, $map_matches);
                list(, $dest, $source, $range) = $map_matches;
                $this->map[$from][$to][] = [
                    'source' => $source,
                    'dest' => $dest,
                    'range' => $range,
                ];
            }
        }
    }

    private function lookup($from, $to, $source): int
    {
        foreach ($this->map[$from][$to] as $map) {
            $offset = $source - $map['source'];
            if ($offset >= 0 && $offset <= $map['range']) {
                return $map['dest'] + $offset;
            }
        }
        return $source;
    }

    private function getNextCategory($category): string
    {
        foreach ($this->map as $from => $to) {
            if ($from == $category) {
                return array_key_first($to);
            }
        }
        return 'seed';
    }

    private function getReverseCategory($category): string
    {
        foreach ($this->map as $from => $to) {
            if (array_key_first($to) == $category) {
                return $from;
            }
        }
        return 'location';
    }
};