<?php

namespace twobitint\AdventOfPHP;

class Input {
    
    public function __construct(private string $input) {}

    public static function make(string $day): self
    {
        return new self(file_get_contents(__DIR__ . "/../input/2023/$day"));
    }

    public function __toString(): string
    {
        return $this->input;
    }

    public function lines(): array
    {
        return explode("\n", $this->input);
    }
}