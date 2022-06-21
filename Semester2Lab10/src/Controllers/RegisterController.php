<?php

namespace Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class RegisterController
{
    private $twig;

    public function __construct()
    {
        $this->twig = new Environment(new FilesystemLoader(dirname(__DIR__) . "/Views"));
    }

    public function run()
    {
        if(isset($_POST["login"]) && isset($_POST["password"]))
        {
            //Переданы данные для регистрации
            $userController = new UserController();

            if($userController->registerUser(htmlspecialchars($_POST["login"]),
                htmlspecialchars($_POST["password"])))
            {
                //Регистрация успешно выполнена
                setcookie("login", $_POST["login"]);
                setcookie("token", md5(md5(htmlspecialchars($_POST["password"]))));
                http_response_code(301);
                header("Location:/user_profile.php");
            }
            else
            {
                //Ошибка регистрации
                http_response_code(301);
                header("Location:/register_user_profile.php?regerror=true");
            }
        }
        else
        {
            if(isset($_REQUEST["regerror"]))
            {
                echo $this->twig->render("register_user_profile.html.twig", [errorMessage => "Произошла ошибка при регистрации."]);
                return;
            }
            //Нет данных для регистрации
            echo $this->twig->render("register_user_profile.html.twig");
        }
    }
}