<?php
require_once 'database.php';

if (array_key_exists('url', $_POST)) {
    $fullUrl = $_POST['url'];

    if (filter_var($fullUrl, FILTER_VALIDATE_URL) === false) {
        $result = ['status' => 'error', 'message' => 'Введенная Вами строка не является ссылкой.'];
        header('Content-Type: text/json; charset=utf-8');
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
        $shortUrl = Database::saveUrl($fullUrl);
        $result = ['status' => 'ok', 'shortUrl' => $shortUrl];
        echo json_encode($result);
    }
}
