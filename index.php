<?php
require_once 'database.php';

if (array_key_exists('link', $_GET)) {
    $fullUrl = Database::getFullUrl($_GET['link']);
    if ($fullUrl) {
        header("Location: $fullUrl");
    } else {
        header("Location: /");
    }
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="script.js"></script>
    <title>Сократитель ссылок</title>
</head>
<body>
<div id="main">
    <form method="post" id="form_url" action="">
        <p><b>Введите ссылку:</b></p>
        <input type="text" id="full_url" size="50">
        <br />
        <br />
        <input type="button" id="btn_send" value="Получить короткую ссылку">
    </form>
    <br />
    <br />
    <br />
    <div id="error">
        <p><b id="message"></b></p>
    </div>
    <div id="url">
        <p><b>Короткая ссылка:</b></p>
        <input type="text" id="short_url" size="30">
    </div>
</div>
</body>
</html>
