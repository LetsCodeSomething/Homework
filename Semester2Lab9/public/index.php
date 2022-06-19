<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Repository\Repository;

$twig = new Environment(new FilesystemLoader(dirname(__DIR__) . "/src/templates"));
try
{
    $repository = new Repository();
    echo $twig->render("index.html.twig", ['components' => $repository->getAllComponents()]);
}
catch (Exception $e)
{
    echo "Произошла ошибка на стороне сервера. Попробуйте обновить страницу или зайти позже.";
}