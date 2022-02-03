<?php

namespace AdminDashboard;

require_once(BASE_PATH . "/admin-dashboard/DataBase.php");

use DataBase\DataBase;

class Home
{
    public function index()
    {
        $db = new DataBase(); // مربوط به 6 تا پست بالای سایت که بر اساس تاریخ نگارش مرتب شده
        // مواردی مانند تعداد کامنت های هر پست و یوزرنیم نویسنده پست را شامل می شود
        $articles = $db->select("SELECT articles.*, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count,
         (SELECT username FROM users WHERE users.id = articles.user_id) AS username FROM articles  ORDER BY `created_at` DESC LIMIT 0,6 ;")
            ->fetchAll();


        // چهار عدد از پست های محبوب را بر اساس ویو نشان میدهد و مواردی مانند تعداد کامنت های 
        // هر پست و یوزرنیم نویسنده پست را شامل می شود 
        $popularArticles = $db->select("SELECT articles.*, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count,
         (SELECT username FROM users WHERE users.id = articles.user_id) AS username FROM articles  ORDER BY `view` DESC LIMIT 0,4 ;")
            ->fetchAll();

        $sidebarPopularArticles = $popularArticles;

        // (قسمت زرد)خط پایین همه دسته بندی های ما را نشان میدهد
        $categories = $db->select('SELECT * FROM `categories` ORDER BY `id` DESC ;');

        // منوهای اصلی را به دست آوردیم و همچنین تعداد زیر منوهای هر منو اصلی را هم به دست 
        // آوردیم به این ترتیب هم منو های اصلی را داریم و هم تعداد زیر منوهای هر منوی اصلی 
        $menus = $db->select('SELECT menus.*, (SELECT COUNT(*) FROM `menus` AS `submenus` WHERE `submenus`.`parent_id` = `menus`.`id`  ) AS `submenu_count`
          FROM `menus` WHERE `parent_id` IS NULL ;')->fetchAll();
        //echo '<pre>';var_dump($menus);exit;

        // در خط پایین همه زیر منو ها را به دست آوردیم
        $submenus = $db->select('SELECT * FROM `menus` WHERE `parent_id` IS NOT NULL ;')->fetchAll();

        // در خط پایین همه اطلاعات ستینگ را به دست می آوریم تا لگو و چیزهای دیگر را به دست آوریم
        $setting = $db->select("SELECT * FROM `websetting`;")->fetch();

        require_once(BASE_PATH . "/template/app/index.php");
    }
    /**
     * یک آرتیکل(پست) مشخص را نمایش میدهد
     * @param int|string $id
     */
    public function show($id)
    {
        $db = new DataBase();
        $article = $db->select("SELECT * FROM `articles` WHERE `id`=? ORDER BY `id` DESC ;", [$id])->fetch();

        $username = $db->select("SELECT * FROM `users` WHERE `id`=? ;", [$article['user_id']])->fetch();

        $commentsCount = $db->select("SELECT COUNT(*) FROM `comments` WHERE `article_id` =? ;", [$id])->fetch(); // تعداد کامنت هر پست

        // همه کامنت های این پست خاص که مورد قبول بوده اند به اضافه نویسنده هر کامنت
        $comments = $db->select("SELECT *,( SELECT `username` FROM `users` WHERE `users`.`id` = `comments`.`user_id`) as `username`
         FROM `comments` WHERE `article_id` = ? and `status` = 'approved' ORDER BY `created_at` DESC ;", [$id])->fetchAll();

        $db->update('articles', $id, ['view'], [$article['view'] + 1]); // هر بازدید از پست یک ویو بالا می رود

        // چهار عدد از پست های محبوب را بر اساس ویو نشان میدهد و مواردی مانند تعداد کامنت های 
        // هر پست و یوزرنیم نویسنده پست را شامل می شود 
        $popularArticles = $db->select("SELECT articles.*, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count,
         (SELECT username FROM users WHERE users.id = articles.user_id) AS username FROM articles  ORDER BY `view` DESC LIMIT 0,4 ;")
            ->fetchAll();
        $sidebarPopularArticles = $popularArticles;

        $categories = $db->select('SELECT * FROM `categories` ORDER BY `id` DESC ;');

        $menus = $db->select('SELECT *, (SELECT COUNT(*) FROM `menus` AS `submenus` WHERE `submenus`.`parent_id` = `menus`.`id`  ) AS `submenu_count`
          FROM `menus` WHERE `parent_id` IS NULL ;')->fetchAll();

        $submenus = $db->select('SELECT * FROM `menus` WHERE `parent_id` IS NOT NULL ;')->fetchAll();

        $setting = $db->select("SELECT * FROM `websetting`;")->fetch();

        require_once(BASE_PATH . "/template/app/show-article.php");
    }

    /**
     * پست های یک کتگوری مشخص را نشان میدهد
     *
     * @param int|string $id
     */
    public function category($id)
    {
        $db = new DataBase();
        $category = $db->select("SELECT * FROM `categories` WHERE `id`=? ;", [$id])->fetch();

        // همه پست هایی که مربوط به اون دسته بندی خاص می شوند به همراه تعداد کامنتها و نویسنده
        $articles = $db->select("SELECT `articles`.*,(SELECT COUNT(*) FROM `comments` WHERE `comments`.`article_id` = `articles`.id) AS `comment_count`,
        (SELECT username FROM `users` WHERE `users`.`id` = `articles`.`user_id`) AS `username` FROM `articles` WHERE `articles`.`cat_id` = ? ;", [$id])
            ->fetchAll();

        $popularArticles = $db->select("SELECT articles.*, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count,
         (SELECT username FROM users WHERE users.id = articles.user_id) AS username FROM articles  ORDER BY `view` DESC LIMIT 0,4 ;")
            ->fetchAll();

        $sidebarPopularArticles = $popularArticles;

        $categories = $db->select('SELECT * FROM `categories` ORDER BY `id` DESC ;');

        $menus = $db->select('SELECT *, (SELECT COUNT(*) FROM `menus` AS `submenus` WHERE `submenus`.`parent_id` = `menus`.`id`  ) AS `submenu_count`
          FROM `menus` WHERE `parent_id` IS NULL ;')->fetchAll();

        $submenus = $db->select('SELECT * FROM `menus` WHERE `parent_id` IS NOT NULL ;')->fetchAll();

        $setting = $db->select("SELECT * FROM `websetting`;")->fetch();


        require_once(BASE_PATH . "/template/app/show-category.php");
    }
    /**
     * ثبت یک کامنت
     *
     * @param array $request
     */
    public function commentStore($request)
    {
        if (isset($_SESSION["user"])) {
            if ($_SESSION["user"]) {

                $db = new DataBase();
                $db->insert(
                    "comments",
                    ["user_id", "article_id", "comment",],
                    [
                        $_SESSION["user"], $request["article_id"], $request["comment"],
                    ]
                );
                $this->redirectBack();
            } else {
                $this->redirectBack();
            }
        } else {
            $this->redirectBack();
        }
    }
    protected function redirectBack()
    {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
}
