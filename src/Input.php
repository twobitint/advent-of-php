<?php

namespace twobitint\AdventOfPHP;

use Iterator;

class Input implements Iterator {
    
    private array $lines;

    public function __construct(private string $input) {
        $this->lines = explode("\n", $input);
    }

    public static function make(string $day): self
    {
        $year = date('Y');
        return new self(file_get_contents(__DIR__ . "/../input/$year/$day"));
    }

    public function __toString(): string
    {
        return $this->input;
    }

    public function lines(): array
    {
        return explode("\n", $this->input);
    }

    public function current(): string
    {
        return current($this->lines);
    }

    public function next(): void
    {
        next($this->lines);
    }

    public function key(): int
    {
        return key($this->lines);
    }

    public function valid(): bool
    {
        return key($this->lines) !== null;
    }

    public function rewind(): void
    {
        reset($this->lines);
    }
}