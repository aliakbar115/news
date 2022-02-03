<?php
namespace AdminDashboard;

class Admin
{
    /**  
     *  ادیمن بودن باید بررسی شود چون همه آن کلاس ها از کلاس ادیمن ارث بری می کنند اینجا در این  
     *  فانکشن تعریف کردیم و در همه جا خود به خود بررسی می شود
     */
    function __construct()
    {
        $auth = new Auth();
        $auth->checkAdmin();
        $this->currentDomain = CURRENT_DOMAIN;
        $this->basePath = BASE_PATH;
    }

    protected function redirect($url)
    {
        header("Location:" . trim($this->currentDomain, "/") . "/" . trim($url, "/"));
        exit;
    }
    protected function redirectBack()
    {
        header("Location:" . $_SERVER["HTTP_REFERER"]);
        exit;
    }

    /**
     * این تابع عکس را می گیرد و ذخیره می کند و آدرس ذخیره شده را بر می گرداند
     *
     * @param array $image
     * @param string $imagePath
     * @param string $imagename
     * @return string|bool
     */
    protected function saveImage($image, $imagePath, $imagename = null) 
    { 
        if ($imagename) { 
            //image["type"]=image/jpeg -- چون به این صورت است 6 تای اول حدف کردیم
            $imagename = $imagename . "." . substr($image["type"], 6, strlen($image["type"]));
        } else {
            $imagename = date("Y-m-d-H-i-s") . "." . substr($image["type"], 6, strlen($image["type"])); // 2022-01-06-16-04-17.jpeg
        }
        $imagetemp = $image["tmp_name"]; // آدرس موقت
        $imagePath = "public/" . $imagePath . "/"; // dar poshe "public rikht" . mesle => public/article-image/

        if (is_uploaded_file($imagetemp)) { // اگر فایلی آپلود شده بود
            if (move_uploaded_file($imagetemp, $imagePath . $imagename)) { // فایل را به آدرس انتقال می دهد

                return $imagePath . $imagename;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    /**
     * این فانکشن عکس را حذف می کند
     *
     * @param string $path
     */
    protected function removeImage($path)
    {
        $path = trim($this->basePath, "/") . "/" . trim($path, "/");
        // $_SERVER["DOCUMENT_ROOT"] : آدرس ریشه فایل را می دهد
        unlink($path); // آدرس ریشه را برای این تابع نیاز داشتیم چون آدرس فایل را از ریشه می خواهد
        // این نابع مسیرها را حدف می کند فقط باید مسیر روت اصلی را بهش بدهیم
        // در واقع این دستور فایل را از آدرسی که بهش دادیم حدف می کند
    }
}
