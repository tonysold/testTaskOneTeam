<?php
namespace App\Classes;
class Team {
    public string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }
}
