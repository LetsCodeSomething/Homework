<?php

namespace Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ProfileController
{
    private $twig;

    public function __construct()
    {
        $this->twig = new Environment(new FilesystemLoader(dirname(__DIR__) . "/Views"));
    }

    public function run()
    {
        if(isset($_COOKIE["token"]))
        {
            $userController = new UserController();
            if($userController->verifyUserByToken(htmlspecialchars($_COOKIE["login"]),
                htmlspecialchars($_COOKIE["token"])))
            {
                echo $this->twig->render("user_profile.html.twig", [login => $_COOKIE["login"], token => $_COOKIE["token"]]);
            }
            else
            {
                //Перенаправление на форму входа
                setcookie("login", "");
                setcookie("token", "");
                http_response_code(301);
                header("Location:/");
            }
        }
        else
        {
            //Пользователь не аутентифицирован, перенаправление на страницу входа
            http_response_code(301);
            header("Location:/");
        }
    }
}