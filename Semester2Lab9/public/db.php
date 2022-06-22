<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Component\Component;
use Repository\Repository;

$twig = new Environment(new FilesystemLoader(dirname(__DIR__) . "/src/templates"));
try
{
    $repository = new Repository();

    $template = $twig->load("index.html.twig");

    if(!isset($_GET['mode']))
    {
        echo "Сервер: в запросе указан неправильный режим работы с базой.";
        return;
    }

    $mode = $_GET['mode'];
    if(!ctype_digit($mode))
    {
        echo "Сервер: режим работы с базой должен быть целым числом.";
        return;
    }

    if($mode == 0)
    {
        if(!isset($_GET['id']))
        {
            echo "Сервер: в запросе не указан ID детали.";
            return;
        }

        if(!isset($_GET['name']))
        {
            echo "Сервер: в запросе не указано название детали.";
            return;
        }

        if(!isset($_GET['description']))
        {
            echo "Сервер: в запросе не указано описание детали.";
            return;
        }

        if(!isset($_GET['material']))
        {
            echo "Сервер: в запросе не указан материал детали.";
            return;
        }

        $id = $_GET['id'];
        $name = $_GET['name'];
        $description = $_GET['description'];
        $material = $_GET['material'];

        if(!ctype_digit($id))
        {
            echo "Сервер: ID детали должен быть целым числом.";
            return;
        }

        if(strlen($name) > 256)
        {
            echo "Сервер: длина названия детали не должна превышать 256 символов.";
            return;
        }

        if(strlen($description) > 256)
        {
            echo "Сервер: длина описания детали не должна превышать 256 символов.";
            return;
        }

        if(strlen($material) > 50)
        {
            echo "Сервер: длина названия материала детали не должна превышать 50 символов.";
            return;
        }

        $component = new Component(htmlspecialchars($id), htmlspecialchars($name),
            htmlspecialchars($description), htmlspecialchars($material));
        $repository->saveComponent($component);

        echo "0" . $template->renderBlock("table", ["components" => $repository->getAllComponents()]);
        return;
    }
    else if($mode == 1)
    {
        if(!isset($_GET['id']))
        {
            echo "Сервер: в запросе не указан ID детали.";
            return;
        }

        $id = $_GET['id'];

        if(!ctype_digit($id))
        {
            echo "Сервер: ID детали должен быть целым числом.";
            return;
        }

        $component = new Component(htmlspecialchars($id), " ", " ", " ");
        $repository->deleteComponent($component);

        echo "0" . $template->renderBlock("table", ["components" =>  $repository->getAllComponents()]);
        return;
    }
    else
    {
        if(!isset($_GET['findmode']))
        {
            echo "Сервер: в запросе указан неправильный режим поиска.";
        }

        if(!isset($_GET['findparam']))
        {
            echo "Сервер: в запросе не указан параметр поиска.";
        }

        $findMode = $_GET['findmode'];
        $findParam = $_GET['findparam'];

        if(!ctype_digit($findMode))
        {
            echo "Сервер: режим поиска в базе должен быть целым числом.";
            return;
        }

        if($findMode == 0)
        {
            if(!ctype_digit($findParam))
            {
                echo "Сервер: ID детали должен быть целым числом.";
                return;
            }

            echo "0" . $template->renderBlock("table", ["components" => $repository->getComponentById($findParam)]);
            return;
        }
        else if($findMode == 1)
        {
            if(strlen($findParam) > 256)
            {
                echo "Сервер: длина названия детали не должна превышать 256 символов.";
                return;
            }

            echo "0" . $template->renderBlock("table", ["components" => $repository->getAllComponentsByValue("name", htmlspecialchars($findParam))]);
            return;
        }
        else if($findMode == 2)
        {
            if(strlen($findParam) > 256)
            {
                echo "Сервер: длина описания детали не должна превышать 256 символов.";
                return;
            }

            echo "0" . $template->renderBlock("table", ["components" => $repository->getAllComponentsByValue("description", htmlspecialchars($findParam))]);
            return;
        }
        else
        {
            if(strlen($findParam) > 50)
            {
                echo "Сервер: длина названия материала детали не должна превышать 50 символов.";
                return;
            }

            echo "0" . $template->renderBlock("table", ["components" => $repository->getAllComponentsByValue("material", htmlspecialchars($findParam))]);
            return;
        }
    }
}
catch (Exception $e)
{
    echo "Произошла ошибка на стороне сервера. Попробуйте обновить страницу или зайти позже.";
}