<?php
namespace App\Classes;
class Round {
    public array $matches = [];

    public function addMatch(Matches $match): void {
        $this->matches[] = $match;
    }

    public function __toString(): string {
        $output = "";
        foreach ($this->matches as $match) {
            $output .= $match . "<br>";
        }
        return $output;
    }
}