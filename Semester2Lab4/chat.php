<?php

function appendMessage($user, $message)
{
    $messages = json_decode(file_get_contents("messages.json"), true);

    $messages["messages"][] = [
        "date" => date("d-m-Y H:i", time()),
        "user" => $user,
        "message" => $message
    ];

    file_put_contents("messages.json", json_encode($messages));

    echo date("d-m-Y H:i", time());
}

if(isset($_GET['chat']))
{
    $messages = file_get_contents('messages.json');
    echo $messages;
}
else
{
    if($_GET['user'] == 'bratishka' && $_GET['password'] == '123')
    {
        appendMessage($_GET['user'], htmlspecialchars($_GET['message']));
    }
    else if($_GET['user'] == 'potato' && $_GET['password'] == 'hehe')
    {
        appendMessage($_GET['user'], htmlspecialchars($_GET['message']));
    }
    else if($_GET['user'] == 'ultra_pro' && $_GET['password'] == 'da')
    {
        appendMessage($_GET['user'], htmlspecialchars($_GET['message']));
    }
    else if($_GET['user'] == 'stranniy' && $_GET['password'] == 'lol')
    {
        appendMessage($_GET['user'], htmlspecialchars($_GET['message']));
    }
    else
    {
        echo '1';
    }
}