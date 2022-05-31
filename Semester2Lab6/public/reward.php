<?php

use src\key_checker\KeyChecker;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

require_once __DIR__ . "/../vendor/autoload.php";

spl_autoload_register(function($className) {
    $path = __DIR__ . "/../" . str_replace("\\", "/", $className) . ".php";
    require($path);
});

$keyChecker = new KeyChecker($_GET["key"]);

$twig = new Environment(new FilesystemLoader(__DIR__ . "/../src/templates"));

$log = new Logger("logger");
$log->pushHandler(new StreamHandler(__DIR__ . "/../log.log"));

try
{
    echo $twig->render("reward.html.twig", ["keycheck" => $keyChecker->check()]);

    if($keyChecker->check())
    {
        $log->info("Пользователь забрал награду");
    }
    else
    {
        $log->error("Пользователь ввёл неправильный ключ, награда не выдана");
    }
}
catch(Exception $e)
{
    echo "Произошла ошибка на стороне сервера. Попробуйте обновить страницу или зайти позже.";
}