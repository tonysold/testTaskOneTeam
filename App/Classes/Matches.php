<?php
namespace App\Classes;
class Matches {
    public Team $homeTeam;
    public Team $awayTeam;

    public function __construct(Team $homeTeam, Team $awayTeam) {
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
    }

    public function __toString(): string {
        return $this->homeTeam->name . " vs " . $this->awayTeam->name;
    }
}