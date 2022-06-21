<?php

use Controllers\ProfileController;

require_once dirname(__DIR__) . "/vendor/autoload.php";

$profileController = new ProfileController();

try
{
    $profileController->run();
}
catch (Exception $e)
{
    http_response_code(500);
}