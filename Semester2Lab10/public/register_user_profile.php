<?php

use Controllers\RegisterController;

require_once dirname(__DIR__) . "/vendor/autoload.php";

$registerController = new RegisterController();

try
{
    $registerController->run();
}
catch (Exception $e)
{
    http_response_code(500);
}