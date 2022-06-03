async function sendMessage()
{
    let usernameTextBox = document.getElementById("usernameTextBox");
    let messageTextBox = document.getElementById("messageTextBox");
    let errorMessageText = document.getElementById("errorMessageText");
    let table = document.getElementById("table");

    let username = usernameTextBox.value;
    let message = messageTextBox.value;

    errorMessageText.innerText = "";

    if(!username)
    {
        errorMessageText.innerText = "Введите ник!";
        return;
    }

    if(username.length > 50)
    {
        errorMessageText.innerText = "Ник в запросе слишком длинный (50 символов макс).";
        return;
    }

    if(!message)
    {
        errorMessageText.innerText = "Введите сообщение!";
        return;
    }

    if(message.length > 150)
    {
        errorMessageText.innerText = "Сообщение в запросе слишком длинное (150 символов макс).";
        return;
    }

    await new Promise((resolve, reject) =>
    {
        let request = new XMLHttpRequest();
        request.responseType = "text";
        request.open("GET", document.URL +
            "addMessage.php?username=" + username + "&message=" + message, true);

        request.onload = function()
        {
            if (request.status !== 200)
            {
                errorMessageText.innerText = "Ошибка отправки запроса. Попробуйте ещё раз.";
            }
            else
            {
                usernameTextBox.value = "";
                messageTextBox.value = "";

                if(request.responseText !== "0")
                {
                    errorMessageText.innerText = request.responseText;
                    return;
                }

                let tableRow = document.createElement("div");
                tableRow.className = "table-row-new";

                let tableCell1 = document.createElement("div");
                tableCell1.className = "table-cell";
                tableCell1.innerText = username;

                let tableCell2 = document.createElement("div");
                tableCell2.className = "table-cell";
                tableCell2.innerText = message;

                tableRow.appendChild(tableCell1);
                tableRow.appendChild(tableCell2);

                table.appendChild(tableRow);
            }
        };

        request.send();
    });
}