<?php

namespace AdminDashboard;

require_once("admin-dashboard/Admin.class.php");
require_once(BASE_PATH . "/admin-dashboard/DataBase.php");

use DataBase\DataBase;

class Menu extends Admin
{
    public function index()
    {
        $db = new DataBase();
        $menus = $db->select("SELECT * FROM `menus` ORDER BY `id` DESC;");
        require_once(BASE_PATH . "/template/admin/menus/index.php");
    }
    public function show($id)
    {
        $db = new DataBase();
        $menu = $db->select("SELECT * FROM `menus` WHERE `id`=?; ", [$id])->fetch();
        require_once(BASE_PATH . "/template/admin/menus/show.php");
    }
    public function create()
    {
        $db = new DataBase;
        $menus = $db->select("SELECT * FROM `menus` WHERE `parent_id` IS NULL ;"); // یعنی اونایی که منو اصلی هستند و پرنت آیدی ندارند
        require_once(BASE_PATH . "/template/admin/menus/create.php");
    }
    public function store($request)
    {
        // در اینجا باید توجه داشته باشیم اگر در فرم کرییت پرنت آیدی روت انتخاب شود 
        // در واقع پرنت آیدی خالی ارسال می شود و در رکوست مقدار پرنت آیدی خالی است
        // در پایین در آرایه اری فیلتر ، خالی ها حدف می شوند پس پرنت آیدی مقدار نمی گیرد
       // و چون در حالت دی فالت در دیتا بیس ، نال است پس نال ثبت می شود و در واقع منو اصلی می شود
        $db = new DataBase(); 
        $db->insert('menus', array_keys(array_filter($request)), array_filter($request));
        $this->redirect("menu");
    }
    public function edit($id)
    {
        $db = new DataBase();
        $menus = $db->select("SELECT * FROM `menus` WHERE `parent_id` IS NULL ;");// منو اصلی
     
        $menu = $db->select("SELECT * FROM `menus` WHERE `id`=?; ", [$id])->fetch();
        require_once(BASE_PATH . "/template/admin/menus/edit.php");
    }
    public function update($request, $id)
    {
        //  این کار را انجام می دهد update نیاز نیست چون خود  array_filter در اینجا به فانکشن 
        $db = new DataBase();
        $db->update('menus', $id, array_keys($request), $request);
        $this->redirect("menu");
    }
    public function delete($id)
    {
        $db = new DataBase();
        $db->delete('menus', $id);
        $this->redirectBack();
    }
}
