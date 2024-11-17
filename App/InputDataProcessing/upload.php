<?php
$upload_dir = __DIR__ . '/../../files/';
$filename = $_FILES['file']['name'];
$filepath = $upload_dir . $filename;

// Проверяем, был ли отправлен файл
if (!isset($_FILES['file'])) {
    echo 'Ошибка: Файл не был отправлен';
    exit;
}

// Проверяем, является ли файл корректным
if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    echo 'Ошибка: Ошибка при загрузке файла';
    exit;
}

// Проверяем, является ли файл JSON
$allowedExtension = 'json';
$extension = pathinfo($filename, PATHINFO_EXTENSION);
if ($extension !== $allowedExtension) {
    echo 'Недопустимый формат файла. Разрешен только формат: ' . $allowedExtension;
    exit;
}

// Проверяем, можно ли записать файл в директорию
if (!is_writable($upload_dir)) {
    echo 'Ошибка: Невозможно записать файл в директорию';
    exit;
}

$new_filename = 'teams.' . $extension;
$new_filepath = $upload_dir . $new_filename;


if (move_uploaded_file($_FILES['file']['tmp_name'], $new_filepath)) {
    header('Location: /processing');
} else {
    echo "Ошибка загрузки файла!";
}
