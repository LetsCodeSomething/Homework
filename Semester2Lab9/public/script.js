let modeComboBox,
    idLabel, idTextBox,
    nameLabel, nameTextBox,
    descriptionLabel, descriptionTextBox,
    materialLabel, materialTextBox,
    findLabel, findComboBox,
    findParamLabel, findParamTextBox,
    submitButton, resetButton,
    errorMessageLabel,
    table;

function processBodyLoad()
{
    modeComboBox = document.getElementById("modeComboBox");
    idLabel = document.getElementById("idLabel");
    idTextBox = document.getElementById("idTextBox");
    nameLabel = document.getElementById("nameLabel");
    nameTextBox = document.getElementById("nameTextBox");
    descriptionLabel = document.getElementById("descriptionLabel");
    descriptionTextBox = document.getElementById("descriptionTextBox");
    materialLabel = document.getElementById("materialLabel");
    materialTextBox = document.getElementById("materialTextBox");
    findLabel = document.getElementById("findLabel");
    findComboBox = document.getElementById("findComboBox");
    findParamLabel = document.getElementById("findParamLabel");
    findParamTextBox = document.getElementById("findParamTextBox");
    submitButton = document.getElementById("submitButton");
    resetButton = document.getElementById("resetButton");
    errorMessageLabel = document.getElementById("errorMessageLabel");
    table = document.getElementById("table");
}

function processModeChange()
{
    if(modeComboBox.selectedIndex === 0)
    {
        idLabel.hidden = false;
        idTextBox.hidden = false;
        nameLabel.hidden = false;
        nameTextBox.hidden = false;
        descriptionLabel.hidden = false;
        descriptionTextBox.hidden = false;
        materialLabel.hidden = false;
        materialTextBox.hidden = false;
        findLabel.hidden = true;
        findComboBox.hidden = true;
        findParamLabel.hidden = true;
        findParamTextBox.hidden = true;
        resetButton.hidden = true;

        idTextBox.value = "";
        nameTextBox.value = "";
        descriptionTextBox.value = "";
        materialTextBox.value = "";
        findParamTextBox.value = "";
        submitButton.value = "Добавить деталь";
    }
    else if(modeComboBox.selectedIndex === 1)
    {
        idLabel.hidden = false;
        idTextBox.hidden = false;
        nameLabel.hidden = true;
        nameTextBox.hidden = true;
        descriptionLabel.hidden = true;
        descriptionTextBox.hidden = true;
        materialLabel.hidden = true;
        materialTextBox.hidden = true;
        findLabel.hidden = true;
        findComboBox.hidden = true;
        findParamLabel.hidden = true;
        findParamTextBox.hidden = true;
        resetButton.hidden = true;

        idTextBox.value = "";
        nameTextBox.value = "";
        descriptionTextBox.value = "";
        materialTextBox.value = "";
        findParamTextBox.value = "";
        submitButton.value = "Удалить деталь";
    }
    else
    {
        idLabel.hidden = true;
        idTextBox.hidden = true;
        nameLabel.hidden = true;
        nameTextBox.hidden = true;
        descriptionLabel.hidden = true;
        descriptionTextBox.hidden = true;
        materialLabel.hidden = true;
        materialTextBox.hidden = true;
        findLabel.hidden = false;
        findComboBox.hidden = false;
        findParamLabel.hidden = false;
        findParamTextBox.hidden = false;
        resetButton.hidden = false;

        idTextBox.value = "";
        nameTextBox.value = "";
        descriptionTextBox.value = "";
        materialTextBox.value = "";
        findParamTextBox.value = "";
        submitButton.value = "Найти детали";
    }

    errorMessageLabel.innerText = "";
}

function processFindChange()
{
    errorMessageLabel.innerText = "";
}

function checkParameters(mode, id, name, description, material, findMode, findParam)
{
    if(!id)
    {
        if(mode < 2)
        {
            return "Укажите ID детали.";
        }
    }

    if(parseInt(id).toString().length !== idTextBox.value.length)
    {
        if(mode < 2)
        {
            return "ID детали должен быть целым числом.";
        }
    }

    if(!name)
    {
        if(mode < 1)
        {
            return "Укажите название детали.";
        }
    }

    if(!description)
    {
        if(mode < 1)
        {
            return "Укажите описание детали.";
        }
    }

    if(!material)
    {
        if(mode < 1)
        {
            return "Укажите материал детали.";
        }
    }

    if(name.length > 256)
    {
        return "Длина названия детали не должна превышать 256 символов.";
    }

    if(description.length > 256)
    {
        return "Длина описания детали не должна превышать 256 символов.";
    }

    if(material.length > 50)
    {
        return "Длина названия материала детали не должна превышать 50 символов.";
    }

    if(mode === 2)
    {
        if(findMode === 0)
        {
            if(!findParam)
            {
                return "Укажите ID детали.";
            }

            if(parseInt(findParam).toString().length !== findParamTextBox.value.length)
            {
                return "ID детали должен быть целым числом.";
            }
        }
        else if(findMode === 1)
        {
            if(!findParam)
            {
                return "Укажите название детали.";
            }

            if(findParam.length > 256)
            {
                return "Длина названия детали не должна превышать 256 символов.";
            }
        }
        else if(findMode === 2)
        {
            if(!findParam)
            {
                return "Укажите описание детали.";
            }

            if(findParam.length > 256)
            {
                return "Длина описания детали не должна превышать 256 символов.";
            }
        }
        else
        {
            if(!findParam)
            {
                return "Укажите материал детали.";
            }

            if(findParam.length > 50)
            {
                return "Длина названия материала детали не должна превышать 50 символов.";
            }
        }
    }

    return null;
}

async function processButtonClick()
{
    errorMessageLabel.innerText = "";

    let mode = modeComboBox.selectedIndex;
    let id = idTextBox.value;
    let name = nameTextBox.value;
    let description = descriptionTextBox.value;
    let material = materialTextBox.value;
    let findMode = findComboBox.selectedIndex;
    let findParam = findParamTextBox.value;

    let checkResult = checkParameters(mode, id, name, description, material, findMode, findParam);

    if(checkResult)
    {
        errorMessageLabel.innerText = checkResult;
        return;
    }

    await new Promise((resolve, reject) =>
    {
        let request = new XMLHttpRequest();
        request.responseType = "text";

        if(mode === 0)
        {
            request.open("GET", document.URL +
                "db.php?mode=0&id=" + id + "&name=" + name + "&description=" + description + "&material=" + material, true);
        }
        else if(mode === 1)
        {
            request.open("GET", document.URL +
                "db.php?mode=1&id=" + id, true);
        }
        else
        {
            request.open("GET", document.URL +
                "db.php?mode=2&findmode=" + findMode + "&findparam=" + findParam, true);
        }

        request.onload = function()
        {
            if (request.status !== 200)
            {
                errorMessageLabel.innerText = "Ошибка отправки запроса. Попробуйте ещё раз.";
            }
            else
            {
                if(request.responseText[0] !== "0")
                {
                    errorMessageLabel.innerText = request.responseText;
                    return;
                }

                table.innerHTML = request.responseText.substring(1);
            }
        };

        request.send();
    });
}

function processResetButtonClick()
{
    window.location.reload();
}