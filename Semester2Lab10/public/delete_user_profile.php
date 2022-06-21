<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";

use Controllers\UserController;

$userController = new UserController();

if(isset($_POST["token"]))
{
    if($userController->verifyUserByToken(htmlspecialchars($_POST["login"]), htmlspecialchars($_POST["token"])))
    {
        $userController->deleteUser(htmlspecialchars($_POST["login"]));
    }

    setcookie("login", "");
    setcookie("token", "");
    http_response_code(301);
    header("Location:/");
}
else
{
    http_response_code(301);
    header("Location:/");
}