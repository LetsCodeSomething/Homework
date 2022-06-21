<?php

namespace Controllers;

use Controllers\UserController;
use Models\DataMapper;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class AppController
{
    private $twig;

    public function __construct()
    {
        $this->twig = new Environment(new FilesystemLoader(dirname(__DIR__) . "/Views"));
    }

    public function run()
    {
        $userController = new UserController();

        if(isset($_COOKIE["token"]))
        {
            if($userController->verifyUserByToken(htmlspecialchars($_COOKIE["login"]),
                htmlspecialchars($_COOKIE["token"])))
            {
                //Перенаправление на страницу профиля
                http_response_code(301);
                header("Location:". $_SERVER["REQUEST_URI"] . "user_profile.php");
            }
            else
            {
                //Перенаправление на форму входа
                setcookie("login", "");
                setcookie("token", "");
                echo $this->twig->render("index.html.twig");
            }
        }
        else
        {
            if(isset($_POST["login"]) && isset($_POST["password"]))
            {
                if($userController->verifyUserByPassword(htmlspecialchars($_POST["login"]),
                    htmlspecialchars($_POST["password"])))
                {
                    //Перенаправление на страницу профиля
                    setcookie("login", htmlspecialchars($_POST["login"]));
                    setcookie("token", md5(md5(htmlspecialchars($_POST["password"]))));
                    http_response_code(301);
                    header("Location:". $_SERVER["REQUEST_URI"] . "user_profile.php");
                }
                else
                {
                    //Перенаправление на форму входа
                    http_response_code(301);
                    header("Location:". $_SERVER["REQUEST_URI"] . "?autherror=true");
                }
            }

            if(isset($_REQUEST["autherror"]))
            {
                echo $this->twig->render("index.html.twig", ["errorMessage" => "Неправильный логин или пароль"]);
            }
            else
            {
                echo $this->twig->render("index.html.twig");
            }
        }
    }
}
