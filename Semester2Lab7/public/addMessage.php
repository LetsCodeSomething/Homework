<?php

try
{
    $usernameGet = htmlspecialchars($_GET['username']);
    $messageGet = htmlspecialchars($_GET['message']);

    if($usernameGet === '')
    {
        echo "Сервер: нет ника в запросе.";
        return;
    }

    if($messageGet === '')
    {
        echo "Сервер: нет сообщения в запросе.";
        return;
    }

    if(strlen($usernameGet) > 50)
    {
        echo "Сервер: ник в запросе слишком длинный (50 символов макс).";
        return;
    }

    if(strlen($messageGet) > 150)
    {
        echo "Сервер: сообщение в запросе слишком длинное (150 символов макс).";
        return;
    }

    $db = new PDO("mysql:host=localhost;dbname=app7", "app7user", "*****");
    $query = $db->prepare("insert into app7.data (username, message) values (\"$usernameGet\",\"$messageGet\")");
    $query->execute();
    echo "0";
}
catch (Exception $e)
{
    echo "Произошла ошибка на стороне сервера. Попробуйте обновить страницу или зайти позже.";
}
