<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . "/../vendor/autoload.php";

$twig = new Environment(new FilesystemLoader(__DIR__ . "/../src/templates"));

$str = file_get_contents(__DIR__ . "/../counter.txt");
$viewsCount = (int)$str;

try
{
    echo $twig->render("index.html.twig", ["viewscount" => $viewsCount]);

    $viewsCount++;
    file_put_contents(__DIR__ . "/../counter.txt", "");
    file_put_contents(__DIR__ . "/../counter.txt", $viewsCount);
}
catch(Exception $e)
{
    echo "Произошла ошибка на стороне сервера. Попробуйте обновить страницу или зайти позже.";
}