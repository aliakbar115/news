<?php
namespace AdminDashboard;

require_once("Admin.class.php");
require_once(BASE_PATH . "/admin-dashboard/DataBase.php");

use DataBase\DataBase;

class Article extends Admin
{
    public  function index()
    {
        $db = new DataBase();
        $articles = $db->select("SELECT * FROM `articles` ORDER BY `id` DESC;"); 
        require_once(BASE_PATH . "/template/admin/articles/index.php");
    }
    public function show($id)
    {
        $db = new DataBase();
        $article = $db->select("SELECT * FROM `articles` WHERE `id`=?; ", [$id])->fetch(); 
        require_once(BASE_PATH . "/template/admin/articles/show.php");
    }
    public function create()
    {
        $db = new DataBase;
        $categories = $db->select("SELECT * FROM `categories` ORDER BY `id` DESC; "); // به صورت نزولی مرتب کن
        require_once(BASE_PATH . "/template/admin/articles/create.php");
    }
    public function store($request)  
    {
        $db = new DataBase;
        if (!empty($request["cat_id"])) {  
            $request["image"] = $this->saveImage($request["image"], "article-image"); 

            if ($request["image"]) { // "$request["image"]" convert to address . example => public/article-image/2021-03-16-19-44-02.jpeg

                $request = array_merge($request, ["user_id" => $_SESSION["user"]]); 
                $db->insert("articles", array_keys($request), $request);
                $this->redirect("article");
            } else {
                $this->$this->redirectBack();
            }
        } else {
            $this->$this->redirectBack();
        }
    }
    public function edit($id)
    {
        $db = new DataBase;
        $article = $db->select("SELECT * FROM `articles` WHERE `id`=?; ", [$id])->fetch();
        $categories = $db->select("SELECT * FROM `categories` ORDER BY `id` DESC; "); // هر مقاله کدام دسته بندی 
        require_once(BASE_PATH . "/template/admin/articles/edit.php");
    }
    public function update($request, $id)
    { 
        $db = new DataBase;
        if (!empty($request["cat_id"])) { 
            if (!empty($request["image"]["tmp_name"])) { 

                $article = $db->select("SELECT * FROM `articles` WHERE `id`=?; ", [$id])->fetch();
                $this->removeImage($article["image"]); // فایل عکس قبلی حذف کن
                $request["image"] = $this->saveImage($request["image"], "article-image");
            } else {
                unset($request["image"]); // این تابع یک متغیر و مقدار درونش را نابود می کنه
            }
            $request = array_merge($request, ["user_id" => $_SESSION["user"]]);
            $db->update("articles", $id, array_keys($request), $request);
            $this->redirect("article");
        } else {
            $this->$this->redirectBack();
        }
    }

    public function delete($id)
    {
        $db = new DataBase;
        $article = $db->select("SELECT * FROM `articles` WHERE `id`=?; ", [$id])->fetch();
        $this->removeImage($article["image"]); // عکس یا فایل را حدف می کند اما آدرس در دیتابیس هنوز هست
        $db->delete("articles", $id); // مقادیر آرتیکل حدف می شود که آدرس عکسم حدف می شود
        $this->redirectBack();
    }
}
