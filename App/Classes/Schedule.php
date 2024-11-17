<?php

namespace App\Classes;

class Schedule
{
    private array $teams;
    private array $rounds = [];

    public function __construct(array $teams)
    {
        $this->teams = $this->initializeTeams($teams);
    }

    private function initializeTeams(array $teams): array
    {
        $teamObjects = array_map(fn($name) => new Team($name), $teams);
        // Если количество команд нечетное выводим ошибку
        if (count($teamObjects) % 2 !== 0) {
            return "Кол-во комманд нечётное";
        }
        return $teamObjects;
    }

    private function rotateTeams(array $teams): array
    {
        $rotated = $teams;
        $numTeams = count($teams);

        // Последний элемент становится вторым
        $rotated[1] = $teams[$numTeams - 1];

        // Остальные элементы сдвигаются
        for ($i = 2; $i < $numTeams; $i++) {
            $rotated[$i] = $teams[$i - 1];
        }

        return $rotated;
    }

    public function generate(): void
    {
        $numTeams = count($this->teams);
        $roundsPerCycle = $numTeams - 1; // Количество туров в одном круге
        $matchesPerRound = $numTeams / 2; // Количество матчей в туре
        $teamList = $this->teams;

        // Генерация первого круга
        for ($round = 0; $round < $roundsPerCycle; $round++) {
            $currentRound = new Round();

            for ($match = 0; $match < $matchesPerRound; $match++) {
                $home = $teamList[$match];
                $away = $teamList[$numTeams - 1 - $match];
                $currentRound->addMatch(new Matches($home, $away));
            }

            $this->rounds[] = $currentRound;
            $teamList = $this->rotateTeams($teamList);
        }

        // Генерация второго круга (реверс хозяев и гостей)
        foreach ($this->rounds as $round) {
            $flippedRound = new Round();
            foreach ($round->matches as $match) {
                $flippedRound->addMatch(new Matches($match->awayTeam, $match->homeTeam));
            }
            $this->rounds[] = $flippedRound;
        }
    }

    public function display(): void
    {
        foreach ($this->rounds as $index => $round) {
            if ($index == 0) {
                echo "Первый круг. <br><br>";
            }
            if (count($this->rounds) / 2 == $index) {
                echo "Второй круг. <br><br>";
            }
            echo "Тур " . ($index + 1) . ":<br>";
            echo $round . "<br>";
        }
    }
}
