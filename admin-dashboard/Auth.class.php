<?php
namespace AdminDashboard;
require_once(BASE_PATH . "/admin-dashboard/DataBase.php");
use DataBase\DataBase;

class Auth
{
    public function login()
    {
        require_once(BASE_PATH . "/template/auth/login.php");
    }

    public function checkLogin($request)
    {
        if (empty($request["email"]) or empty($request["password"])) { 
            $this->redirectBack();
        } else {

            $db = new DataBase(); 
            $user = $db->select("SELECT * FROM `users` WHERE `email`=?; ", [$request["email"]])->fetch();
            
            if ($user) { 
                if (password_verify($request["password"], $user["password"])) {
                    // تابع بالا مقایسه پسورد خام با پسورد هش شده است که دو متغیر ورودی می گیرد
                    $_SESSION["user"] = $user["id"]; 
                    $this->redirect("admin"); // در صفحه ادیمن بررسی می شود که ادمین است یا نه
                } else {
                    $this->redirectBack();
                }
            } else {

                $this->redirectBack();
            }
        }
    }

    public function checkUser()
    {
        if (isset($_SESSION["user"])) {
            $db = new DataBase();
            $user = $db->select("SELECT * FROM `users` WHERE `id`=?; ", [$_SESSION["user"]])->fetch();
            if ($user) { // اگر همچین کاربری وجود داشت
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function register()
    {
        require_once(BASE_PATH . "/template/auth/register.php");
    }

    public function registerStore($request)
    {
        if (empty($request["email"]) or empty($request["password"])) { // اگر فقط یکیشونم خالی بود ایف اجرا شود

            $this->redirectBack();
        } elseif (strlen($request["password"]) < 8) {

            $this->redirectBack();
        } elseif (!filter_var($request["email"], FILTER_VALIDATE_EMAIL)) {  // filter_var در صورت خطا فالس بر می گرداند 
             
            $this->redirectBack();  
        } else { 

            $db = new DataBase();
            $user = $db->select("SELECT * FROM `users` WHERE `email`=?; ", [$request["email"]])->fetch();
            if ($user) { // ممکن است یک ایمیل قبلا وجود داشته دوباره بخواد ثبت نام کنه
            
                $this->redirectBack();
            } else {
                $request["password"] = $this->hash($request["password"]); // پسورد رمز گزاری کن
                $db->insert("users", array_keys($request), $request); // اطلاعات فرم ثبت نام ثبت کن
                $this->redirect("login"); // بعدشم به صفحه لاگین برود
            }
        }
    }
    public function logout()
    {
        if (isset($_SESSION["user"])) { // یعنی کاربر لاگین بود

            unset($_SESSION["user"]);
            session_destroy(); // تمام سشن ها را نابود می کند
        }
        $this->redirectBack();
    }

    public function checkAdmin()
    {
        if (isset($_SESSION["user"])) {
            $db = new DataBase();
            $user = $db->select("SELECT * FROM `users` WHERE `id`=?; ", [$_SESSION["user"]])->fetch();
            if ($user) { // اگر همچین کاربری وجود داشت
                if ($user["permission"] != "admin") { // اگر ادمین نبود

                    $this->redirect("home");
                }
            } else {
                $this->redirect("home");
            }
        } else {

            $this->redirect("home");
        }
    }

    public function checkAdmin2()
    {
        if (isset($_SESSION["user"])) {
            $db = new DataBase();
            $user = $db->select("SELECT * FROM `users` WHERE `id`=?; ", [$_SESSION["user"]])->fetch();
            if ($user) { // اگر همچین کاربری وجود داشت
                if ($user["permission"] == "admin") { // اگر ادمین نبود

                    return true;
                }else{
                    return false;
                }
            } else {
                return false;
            }
        } else {

            return false;
        }
    }

    protected function redirect($url)
    {
        header("Location: ". trim(CURRENT_DOMAIN, '/ ') . '/' . trim($url, '/ '));
        exit();
    }

    protected function redirectBack()
    {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
    /**
     * عملیات هش کردن پسورد
     * @param string $string
     * @return string
     */
    public function hash($string)
    {
        // این فانکشن به کمک تابع پایین پسوورد را هش می کند
        $hashString = password_hash($string, PASSWORD_DEFAULT);
        return $hashString;
    }
}
