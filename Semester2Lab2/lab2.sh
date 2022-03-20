#!/bin/bash

if [ -z $lab2filename ]; then
    echo "Ошибка: не задана переменная среды \"lab2filename\", которая должна содержать имя файла."
else
    if [ -z $1 ]; then
        echo "Ошибка: не задана строка для записи в файл (аргумент 1)."
    else
        f=$(find . -name $lab2filename)
        
        if [ -z $f ]; then
            touch $lab2filename
            echo $1 >> $lab2filename
            echo "Создан файл \"$lab2filename\", аргумент 1 \"$1\" записан в файл."
            
            t=$(file $lab2filename)
            
            echo "Тип созданного файла: $t"
        else
            echo $1 > $lab2filename
            echo "Содержимое файла \"$lab2filename\" перезаписано на аргумент 1 \"$1\"."
            
            t=$(file $lab2filename)
            
            echo "Тип перезаписанного файла: $t"
        fi
    fi
fi


