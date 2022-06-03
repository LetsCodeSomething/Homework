<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once dirname(__DIR__) . "/vendor/autoload.php";

$twig = new Environment(new FilesystemLoader(dirname(__DIR__) . "/src/templates"));
try
{
    $db = new PDO("mysql:host=localhost;dbname=app7", "app7user", "*****");
    $query = $db->prepare("select * from app7.data");
    $query->execute();
    $data = $query->fetchAll();

    echo $twig->render("index.html.twig", ['data' => $data]);
}
catch (Exception $e)
{
    echo "Произошла ошибка на стороне сервера. Попробуйте обновить страницу или зайти позже.";
}
