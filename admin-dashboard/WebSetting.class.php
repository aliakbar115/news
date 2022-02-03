<?php

namespace AdminDashboard;

require_once("admin-dashboard/Admin.class.php");
require_once(BASE_PATH . "/admin-dashboard/DataBase.php");

use DataBase\DataBase;

class WebSetting extends Admin
{
    public function index()
    {
        $db = new DataBase();
        $setting = $db->select("SELECT * FROM `websetting`;")->fetch();
        require_once(BASE_PATH . "/template/admin/web-setting/index.php");
    }

    public function set()
    {
        $db = new DataBase();  // باید توجه داشت فقط یک رکورد دارد چون برای سایت فقط یک لگو یا تایتل داریم 
        $setting = $db->select("SELECT * FROM `websetting`;")->fetch();
        require_once(BASE_PATH . "/template/admin/web-setting/set.php");
    }
  
    public function store($request)
    {
        // همزمان که عملیات اینزرت انجام می شود عملیات آبدیت هم انجام می شود چون یکی فقط است
        $db = new DataBase();
        $setting = $db->select("SELECT * FROM `websetting`;")->fetch();
        
        if (!empty($request["logo"]["tmp_name"])) {
            $this->removeImage($setting["logo"]);
            $request["logo"] = $this->saveImage($request["logo"], "setting", "logo");
        } else { 
            unset($request["logo"]);
        }

        if (!empty($request["icon"]["tmp_name"])) { 
            $this->removeImage($setting["icon"]);
            $request["icon"] = $this->saveImage($request["icon"], "setting", "icon");
        } else { 
            unset($request["icon"]); 
        }

        // در خطوط پایین کاری می کنیم که فقط بشود یک رکورد ثبت کرد یعنی اگر رکورد از قبل 
        // وجود نداشته باشد اینزرت می کند ولی اگر وجود داشته باشد آبدیت می کند 
        if (!empty($setting)) { // یعنی حتما قبلا یه ستینگ داشته است پس آبدیت می کنیم
            
            $db->update("websetting", $setting["id"], array_keys($request), $request);
        } else { // اگر قبل این هیچ ستینگی نداشته است
            $db->insert("websetting", array_keys($request), $request);
        }
        $this->redirect("web-setting");
    }
}
