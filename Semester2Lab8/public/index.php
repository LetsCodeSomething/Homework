<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";
require_once dirname(__DIR__) . "/src/Component/Component.php";

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Component\Component;

$twig = new Environment(new FilesystemLoader(dirname(__DIR__) . "/src/templates"));
try
{
    $c = new Component();
    echo $twig->render("index.html.twig", ['components' => $c->getAll()]);
}
catch (Exception $e)
{
    echo "Произошла ошибка на стороне сервера. Попробуйте обновить страницу или зайти позже.";
}
