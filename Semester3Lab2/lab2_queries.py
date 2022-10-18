import sqlite3
import pandas as pd

con = sqlite3.connect("lab2_db.sqlite")
cursor = con.cursor()

#1) Выбор всех покупок с демонстрацией названия компании-поставщика.
#Сортировка по названию компаний в алфавитном порядке.
print("=================================Запрос 1:=================================")
print(pd.read_sql('''select TransactionItem.transaction_id as \"ID покупки\", 
                            vendor_name as \"Название поставщика\",
                            TransactionItem.product_id as \"ID товара\",
                            TransactionItem.product_price_rubles as \"Рубли\",
                            TransactionItem.product_price_copecks as \"Копейки\",
                            TransactionItem.product_amount as Количество
                     from TransactionItem 
                     inner join Vendor v on v.vendor_id = TransactionItem.vendor_id 
                     order by \"Название поставщика\"''', con))

#2) Выбор всех компаний-поставщиков с демонстрацией названия
#населённых пунктов, в которых они располагаются.
#Сортировка по названию населённого пункта в алфавитном порядке.
print("=================================Запрос 2:=================================")
print(pd.read_sql('''select Vendor.vendor_id as \"ID поставщика\",
                            Vendor.vendor_name as \"Название поставщика\",
                            Vendor.vendor_phone as Телефон,
                            location_name as \"Нас. пункт\",
                            Vendor.vendor_address as Адрес
                     from Vendor 
                     inner join Location l on l.location_id = Vendor.location_id 
                     order by \"Нас. пункт\"''', con))

#3) Выбор всех поставщиков и количества товаров, которые продаёт каждый из них.
print("=================================Запрос 3:=================================")
print(pd.read_sql('''select vendor_name as Поставщик,
                            count(Vendors_Products_List.product_id) as \"Кол-во разных товаров\" 
                     from Vendors_Products_List
                     inner join Vendor v on v.vendor_id = Vendors_Products_List.vendor_id 
                     group by Vendors_Products_List.vendor_id 
                     order by vendor_name''', con))

#4) Выбор суммарного количества денег, затраченных на покупку товаров у каждого поставщика.
#printf() используется для отключения экспоненциальной формы вещественных чисел.
print("=================================Запрос 4:=================================")
print(pd.read_sql('''select vendor_name as Поставщик,
                            printf(\"%f\", sum(TransactionItem.product_amount * (
                                TransactionItem.product_price_rubles + 
                                TransactionItem.product_price_copecks / 100.0))) as \"Сумма\"
                     from TransactionItem 
                     inner join Vendor v on v.vendor_id = TransactionItem.vendor_id 
                     group by TransactionItem.vendor_id''', con))

#5) Выбор тех поставщиков, которые продают больше трёх разных товаров.
print("=================================Запрос 5:=================================")
print(pd.read_sql('''select Vendor.vendor_name as Поставщик
                     from Vendor
                     where (select count(product_id) 
                            from Vendors_Products_List
                            where vendor_id = Vendor.vendor_id) > 3''', con))

#6) Выбор всех записей о покупках тех товаров, которые продаются больше чем одним поставщиком.
print("=================================Запрос 6:=================================")
print(pd.read_sql('''select TransactionItem.transaction_id as \"ID покупки\",
                            TransactionItem.vendor_id as Поставщик,
                            TransactionItem.product_id as \"ID товара\",
                            product_name as Товар
                     from TransactionItem
                     inner join Product p on p.product_id = TransactionItem.product_id
                     where (select distinct count(Vendors_Products_List.vendor_id) from Vendors_Products_List
                            where Vendors_Products_List.product_id = TransactionItem.product_id) > 1''', con))

#7) Добавление новых записей в таблицу местоположений.
cursor.execute('''insert into Location(location_id, location_name) values
                     (10, \"Сыктывкар\"), (11, \"Воронеж\"),
                     (12, \"Петрозаводск\"), (13, \"Ростов-на-Дону\"),
                     (14, \"Волгоград\"), (15, \"Тамбов\"),
                     (16, \"Пенза\"), (17, \"Тольятти\")''')

#8) Удаление записей о всех поставщиках, в названиях которых нет "ООО".
cursor.execute('''delete from Vendor where vendor_name not like \"ООО%\"''')

con.commit()
con.close()