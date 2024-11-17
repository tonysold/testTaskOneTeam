<?php
$file = __DIR__ . '/../../files/teams.json';

// Проверяем, задан ли URL в POST-запросе
if (!isset($_POST['url'])) {
    http_response_code(400);
    echo 'Ошибка: URL не указан';
    exit;
}

$jsonUrl = $_POST['url'];

// Проверяем, является ли URL корректным
if (!filter_var($jsonUrl, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo 'Ошибка: Некорректный URL';
    exit;
}

// Пытаемся прочитать JSON-данные из URL
$jsonData = json_decode(file_get_contents($jsonUrl), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    echo 'Ошибка: Не удалось разобрать JSON-данные или некорректный URL';
    exit;
}

// Проверяем, можно ли записать данные в файл
if (!is_writable($file)) {
    http_response_code(500);
    echo 'Ошибка: Невозможно записать данные в файл';
    exit;
}

// Записываем JSON-данные в файл
$result = file_put_contents($file, json_encode($jsonData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

// Проверяем, была ли запись данных успешной
if ($result === false) {
    http_response_code(500);
    echo 'Ошибка: Не удалось записать данные в файл';
    exit;
}

// Если мы дошли до этого момента, значит все прошло успешно!
header('Location: /processing');