async function processMessage()
{
    let userTextbox = document.getElementById("user");
    let passwordTextbox = document.getElementById("password");
    let messageTextbox = document.getElementById("message");
    let errorMessage = document.getElementById("error-message");

    let user = userTextbox.value;
    let password = passwordTextbox.value;
    let message = messageTextbox.value;

    errorMessage.innerText = "";
    if(!user)
    {
        errorMessage.innerText = "Введите логин";
        return;
    }
    if(!password)
    {
        errorMessage.innerText = "Введите пароль";
        return;
    }
    if(!message)
    {
        errorMessage.innerText = "Введите сообщение";
        return;
    }

    await new Promise((resolve, reject) =>
    {
        let request = new XMLHttpRequest();
        request.responseType = "text";
        request.open("GET", document.URL +
            "chat.php?user=" + user + "&password=" + password + "&message=" + message, true);

        request.onload = function()
        {
            if (request.status !== 200)
            {
                errorMessage.innerText = "Ошибка отправки запроса. Попробуйте ещё раз";
                reject();
            }
            else
            {
                if(request.responseText === "1")
                {
                    errorMessage.innerText = "Неправильный логин или пароль.";
                }
                else
                {
                    let chatForm = document.getElementById("chatform");
                    chatForm.innerHTML += "[" + request.responseText + "] " + user + ": " + message + "<br>";
                    messageTextbox.innerText = "";
                }
            }
        };

        request.send();
    });
}

async function getMessages()
{
    let chatForm = document.getElementById("chatform");
    chatForm.innerHTML = "";

    await new Promise((resolve, reject) =>
    {
        let request = new XMLHttpRequest();
        request.responseType = "text";
        request.open("GET", document.URL +
            "chat.php?chat=true", true);

        request.onload = function()
        {
            if (request.status !== 200)
            {
                reject();
            }
            else
            {
                let response = JSON.parse(request.responseText);

                for(let i = 0; i < response.messages.length; i++)
                {
                    chatForm.innerHTML += "[" + response.messages[i].date + "] "
                         + response.messages[i].user + ": " + response.messages[i].message + "<br>";
                }
            }
        };

        request.send();
    });
}

