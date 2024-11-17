<?php
$filepath = __DIR__ . '/../../files/teams.json';
$teamsArrFromVar = $_POST['paste'] ?? 0;
$jsonFromFile = file_get_contents($filepath);
if (!isset($_POST['paste'])) {
    $resourse = $jsonFromFile;
}
else {
    $resourse = $_POST['paste'];
}
$teamsArr = json_decode($resourse, true);

$teamNames = [];
foreach ($teamsArr['teams'] as $team) {
    $teamNames[] = $team['title'];
}
shuffle($teamNames);

$schedule = new App\Classes\Schedule($teamNames);
$schedule->generate();
$schedule->display();
