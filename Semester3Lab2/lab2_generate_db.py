#Создание базы данных

import sqlite3

con = sqlite3.connect("lab2_db.sqlite")

con.executescript('''
CREATE TABLE IF NOT EXISTS `Location` (
  `location_id` INT UNSIGNED NOT NULL,
  `location_name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`location_id`));

CREATE TABLE IF NOT EXISTS `Vendor` (
  `vendor_id` INT UNSIGNED NOT NULL,
  `vendor_name` VARCHAR(100) NOT NULL,
  `vendor_address` VARCHAR(100) NOT NULL,
  `vendor_phone` VARCHAR(20) NOT NULL,
  `location_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`vendor_id`),
  CONSTRAINT `fk_Vendor_Locations1`
    FOREIGN KEY (`location_id`)
    REFERENCES `Location` (`location_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE TABLE IF NOT EXISTS `Product` (
  `product_id` INT UNSIGNED NOT NULL,
  `product_name` VARCHAR(50) NOT NULL,
  `product_measuring_units` VARCHAR(8) NOT NULL,
  `product_amount` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`product_id`));

CREATE TABLE IF NOT EXISTS `Transactions` (
  `transaction_id` INT UNSIGNED NOT NULL,
  `transaction_datetime` DATETIME NOT NULL,
  PRIMARY KEY (`transaction_id`));

CREATE TABLE IF NOT EXISTS `Vendors_Products_List` (
  `vendor_id` INT UNSIGNED NOT NULL,
  `product_id` INT UNSIGNED NOT NULL,
  `product_price_rubles` INT UNSIGNED NOT NULL,
  `product_price_copecks` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`vendor_id`, `product_id`),
  CONSTRAINT `fk_Vendor_has_Product_Vendor1`
    FOREIGN KEY (`vendor_id`)
    REFERENCES `Vendor` (`vendor_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Vendor_has_Product_Product1`
    FOREIGN KEY (`product_id`)
    REFERENCES `Product` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE TABLE IF NOT EXISTS `TransactionItem` (
  `transaction_id` INT UNSIGNED NOT NULL,
  `vendor_id` INT UNSIGNED NOT NULL,
  `product_id` INT UNSIGNED NOT NULL,
  `product_price_rubles` INT UNSIGNED NOT NULL,
  `product_price_copecks` INT UNSIGNED NOT NULL,
  `product_amount` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`vendor_id`, `product_id`, `transaction_id`),
  CONSTRAINT `fk_TransactionItem_Vendors_Products_List1`
    FOREIGN KEY (`vendor_id` , `product_id`)
    REFERENCES `Vendors_Products_List` (`vendor_id` , `product_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TransactionItem_Transaction1`
    FOREIGN KEY (`transaction_id`)
    REFERENCES `Transactions` (`transaction_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
''')

con.commit()
con.close()