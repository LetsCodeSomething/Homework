<?php

setcookie("login", "");
setcookie("token", "");

http_response_code(301);
header("Location:/");