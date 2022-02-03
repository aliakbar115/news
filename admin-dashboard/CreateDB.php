<?php
namespace DataBase;
require_once(BASE_PATH . "/admin-dashboard/DataBase.php");

class CreateDB extends DataBase
{
   private $createTableQueries = [
      "CREATE TABLE `categories`(
             `id` INT(11) NOT NULL AUTO_INCREMENT,
             `name` VARCHAR(200) COLLATE utf8_persian_ci  NOT NULL,
             `created_at` DATETIME NOT NULL,  
             `updated_at` DATETIME DEFAULT NULL,
             PRIMARY KEY(`id`)  
             ) ENGINE=InnoDB DEFAULT CHARSET =utf8 COLLATE=utf8_persian_ci;",

      "CREATE TABLE `users`(
             `id` INT(11) NOT NULL AUTO_INCREMENT,
             `username` VARCHAR(100) COLLATE utf8_persian_ci NOT NULL,
             `email` VARCHAR(100) COLLATE utf8_persian_ci NOT NULL,
             `password` VARCHAR(100) COLLATE utf8_persian_ci NOT NULL,
             `permission` enum('user','admin') COLLATE utf8_persian_ci NOT NULL DEFAULT 'user', /* در ابتدا همه یوزر هستند */
             `created_at` DATETIME NOT NULL,            
             `updated_at` DATETIME DEFAULT NULL,
             PRIMARY KEY(`id`), 
             UNIQUE KEY `email` (`email`)
             ) ENGINE=InnoDB DEFAULT CHARSET =utf8 COLLATE=utf8_persian_ci;",

      "CREATE TABLE `articles` (
             `id` int(11) NOT NULL AUTO_INCREMENT,
             `title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
             `summary` text COLLATE utf8_persian_ci NOT NULL,  /* خلاطه ای از پست ما */
             `body` text COLLATE utf8_persian_ci NOT NULL,
             `view` int(11) NOT NULL DEFAULT '0',    /* تعداد بازدید از ابتدا صفر است */
             `user_id` int(11)  NOT NULL,
             `cat_id` int(11)  NOT NULL,
             `image` varchar(200) COLLATE utf8_persian_ci NOT NULL,
             `status` enum('disable','enable') COLLATE utf8_persian_ci NOT NULL DEFAULT 'disable',
             `created_at` datetime NOT NULL,            /* در ابتدا همه پست ها غیر فعال هستند */
             `updated_at` datetime DEFAULT NULL,
             PRIMARY KEY (`id`), 
             FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
             FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
             ) ENGINE=InnoDB DEFAULT CHARSET =utf8 COLLATE=utf8_persian_ci;",

      "CREATE TABLE `comments`(    
             `id` INT(11) NOT NULL AUTO_INCREMENT,
             `user_id` INT(11) NOT NULL,
             `comment` TEXT COLLATE utf8_persian_ci NOT NULL,
             `article_id` INT(11) NOT NULL,           
             `status` enum('unseen','seen','approved') COLLATE utf8_persian_ci NOT NULL DEFAULT 'unseen',
             `created_at` DATETIME NOT NULL,            
             `updated_at` DATETIME DEFAULT NULL,
             PRIMARY KEY(`id`), 
             FOREIGN KEY(`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
             FOREIGN KEY(`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
             ) ENGINE=InnoDB DEFAULT CHARSET =utf8 COLLATE=utf8_persian_ci;",

      "CREATE TABLE `websetting`( 
             `id` INT(11) NOT NULL AUTO_INCREMENT,
             `title` TEXT COLLATE utf8_persian_ci DEFAULT NULL,  
             `description` TEXT COLLATE utf8_persian_ci DEFAULT NULL,
             `keywords` TEXT COLLATE utf8_persian_ci DEFAULT NULL,
             `logo` TEXT COLLATE utf8_persian_ci DEFAULT NULL,
             `icon` TEXT COLLATE utf8_persian_ci DEFAULT NULL,
             `created_at` DATETIME NOT NULL,            
             `updated_at` DATETIME DEFAULT NULL,
             PRIMARY KEY(`id`)
             ) ENGINE=InnoDB DEFAULT CHARSET =utf8 COLLATE=utf8_persian_ci;",

      "CREATE TABLE `menus`(
             `id` INT(11) NOT NULL AUTO_INCREMENT,
             `name` VARCHAR(200) COLLATE utf8_persian_ci  NOT NULL,
             `url` VARCHAR(300) COLLATE utf8_persian_ci NOT NULL,
             `parent_id` INT(11) DEFAULT NULL,  
             `created_at` DATETIME NOT NULL,            
             `updated_at` DATETIME DEFAULT NULL,
             PRIMARY KEY(`id`),
             FOREIGN KEY(`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
             ) ENGINE=InnoDB DEFAULT CHARSET =utf8 COLLATE=utf8_persian_ci;",

   ];  
   /**
    * در پایین یک مقدار دیفالت همزمان با ساخت دیتابیس به جداول پاس می دهیم که خالی نباشد
    *
    * @var array
    */
   private $tableInitializes = [
      [
         'table' => 'users',
         'fields' => ['username', 'email', 'password', 'permission'],
         'values' => [
            'aliakbar',
            'soheil.teimory131@gmail.com',
            '$2y$10$33i/Hmo3Acy53WaPZqznLe6RXUSv9xFEJj243bV7TAKMFujpjTMTK',
            'admin',
         ],
      ],
   ];
   /**
    * هر جا این فانکشن صدا شود جداول ما ساخته می شود
    *
    * @return void
    */
   public function run()
   {  
      foreach ($this->createTableQueries as $createTableQuery) {
         $this->createTable($createTableQuery);
      }
      foreach ($this->tableInitializes as $tableInitialize) { // ساخت یک مقدار دیفالت و ادمین
         $this->insert($tableInitialize['table'], $tableInitialize['fields'], $tableInitialize['values']);
      }
   }
}
