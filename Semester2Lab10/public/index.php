<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";

use Controllers\AppController;

$app = new AppController();

try
{
    $app->run();
}
catch (Exception $e)
{
    http_response_code(500);
}
