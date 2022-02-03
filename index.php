<?php
session_start();
require_once("admin-dashboard/helpers.php");

//config
define("BASE_PATH", __DIR__); // مسیر اولیه  E:\Program Files\Ampps\www\host-project
define("CURRENT_DOMAIN", currnetDomain() . "/"); // دامین ما را بر می گرداند
define("DISPLAY_ERROR", true); // زمان تحویل به مشتری باید فالس باشد که مشتری خطاها را نبیند
define("DB_HOST", "localhost");
define("DB_NAME", "shoponl2_project");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "mysql");


if (DISPLAY_ERROR) { 
    ini_set("display_errors", 1); // change php.ini
    ini_set("display_startup_errors", 1);  // change php.ini
    error_reporting(E_ALL);
} else { 
    ini_set("display_errors", 0);
    ini_set("display_startup_errors", 0);
    error_reporting(0);
}

require_once("admin-dashboard/Category.class.php");
require_once("admin-dashboard/Article.class.php");
require_once("admin-dashboard/CreateDB.php");
require_once("admin-dashboard/Menu.class.php");
require_once("admin-dashboard/WebSetting.class.php");
require_once("admin-dashboard/User.class.php");
require_once("admin-dashboard/Auth.class.php");
require_once("admin-dashboard/Home.class.php");
require_once("admin-dashboard/Comment.class.php");
require_once("admin-dashboard/Dashboard.class.php");


// $createDB= new CreateDB(); // فقط یک بار استفاده می کنیم و دیگر نیازی نیست
// $createDB->run();

/**
 * این فانکشن همه روت های ما را بررسی می کند و روت وارد شده توسط کاربر را پیدا کرده و به فانکشن و کلاس مربوطه متصل می نماید
 *
 * @param string $reservedUrl
 * @param string $class
 * @param string $method
 * @param string $requestMethod
 * @return void
 */
function uri($reservedUrl, $class, $method, $requestMethod = "GET")
{
    $currentUrl = explode("?", currentUrl());
    $currentUrl = $currentUrl[0];
    $currentUrl = str_replace(CURRENT_DOMAIN, "", $currentUrl);
    $currentUrl = trim($currentUrl, "/");
    $currentUrlArray = explode("/", $currentUrl); // بر اساس اسلش تبدیل به آرایه شد
    $currentUrlArray = array_filter($currentUrlArray); // خانه خالی را حذف می کند

    $reservedUrl = trim($reservedUrl, "/");
    $reservedUrlArray = explode("/", $reservedUrl);
    $reservedUrlArray = array_filter($reservedUrlArray);

    //compare
    if (count($currentUrlArray) != count($reservedUrlArray) or methodFiled() != $requestMethod) {
        return false;
    }
    $parameters = []; // متغیر ها در اینجا ریخته می شود

    for ($key = 0; $key < count($currentUrlArray); $key++) {
        if ($reservedUrlArray[$key][0] == "{" && $reservedUrlArray[$key][strlen($reservedUrlArray[$key]) - 1] == "}") {

            array_push($parameters, $currentUrlArray[$key]);
        } elseif ($reservedUrlArray[$key] != $currentUrlArray[$key]) {

            return false;
        }
    }

    if (methodFiled() == "POST") {
        $request = isset($_FILES) ? array_merge($_POST, $_FILES) : $_POST;
        $parameters = array_merge([$request], $parameters); // [$request]   (آرایه)نکته مهم
    }

    // نکته : برای استفاده از " یا \ و یا غیره در استرینگ باید قبلش یک \ بگرازیم تا بشناسد
    $class = "AdminDashboard\\" . $class;
    $object = new $class;
    call_user_func_array([$object, $method], $parameters); // https://www.php.net/manual/en/function.call-user-func-array.php
    exit;
}


//category
uri("category", "Category", "index");
uri("category/show/{id}", "Category", "show");
uri("category/create", "Category", "create");
uri("category/store", "Category", "store", "POST");
uri("category/edit/{id}", "Category", "edit");
uri("category/update/{id}", "Category", "update", "POST");
uri("category/delete/{id}", "Category", "delete");
//article
uri("article", "Article", "index");
uri("article/show/{id}", "Article", "show");
uri("article/create", "Article", "create");
uri("article/store", "Article", "store", "POST");
uri("article/edit/{id}", "Article", "edit");
uri("article/update/{id}", "Article", "update", "POST");
uri("article/delete/{id}", "Article", "delete");
//menu
uri("menu", "Menu", "index");
uri("menu/show/{id}", "Menu", "show");
uri("menu/create", "Menu", "create");
uri("menu/store", "Menu", "store", "POST");
uri("menu/edit/{id}", "Menu", "edit");
uri("menu/update/{id}", "Menu", "update", "POST");
uri("menu/delete/{id}", "Menu", "delete");
//web setting
uri("web-setting", "WebSetting", "index");
uri("web-setting/set", "WebSetting", "set");
uri("web-setting/store", "WebSetting", "store", "POST");
//user
uri("user", "User", "index");
uri("user/permission/{id}", "User", "permission");
uri("user/edit/{id}", "User", "edit");
uri("user/update/{id}", "User", "update", "POST");
uri("user/delete/{id}", "User", "delete");
//auth
uri("login", "Auth", "login");
uri("check-login", "Auth", "checkLogin", "POST");
uri("register", "Auth", "register");
uri("register/store", "Auth", "registerStore", "POST");
uri("logout", "Auth", "logout");
//home
uri("", "Home", "index");
uri("home", "Home", "index");
uri("show-article/{id}", "Home", "show");
uri("show-category/{id}", "Home", "category");
uri("comment-store", "Home", "commentStore", "POST");
//comment
uri("comment", "Comment", "index");
uri("comment/show/{id}", "Comment", "show");
uri("comment/approved/{id}", "Comment", "approved");
//dashboard
uri("admin", "Dashboard", "index");

echo "404-page not found";
exit;
