<?php

namespace DataBase;

use PDO;
use PDOException;

class DataBase
{
    private $connection;
    private $option = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    ];
    private $dbHost = DB_HOST;
    private $dbName = DB_NAME;
    private $dbUsername = DB_USERNAME;
    private $dbPassword = DB_PASSWORD;

    /**
     * هر موقع این کلاس فراخوانی شود به طور خودکار از این فانکشن استفاده می شود به دیتا بیس وصل می شویم
     */
    function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName,
                $this->dbUsername,
                $this->dbPassword,
                $this->option
            );
        } catch (PDOException $e) {
            echo "<div style='color: red;'> There is some problem in connection f construct: </div>" . $e->getMessage();
        }
    }
    /**
     * این فانکشن در واقع فقط اسکیوال ما را اجرا می کند و پاسخ آن را بر می گرداند
     *
     * @param string $sql
     * @param array $values
     * @return object
     */
    public function select($sql, $values = [])
    {
        try {
            if (empty($values)) {
                return $this->connection->query($sql);
            } else {
                $stmt = $this->connection->prepare($sql);
                $stmt->execute($values); // The answer is poured into the variable "$stmt"  نکته مهم
                $result = $stmt;
                return $result;
            }
        } catch (PDOException $e) {
            echo "<div style='color: red;'> There is some problem in select: </div>" . $e->getMessage();
            return false;
        }
    }
    /**
     * عملیات اینزرت : این تابع در واقع اسکیوال را می سازد و اجرا می کند
     *
     * @param string $tableName
     * @param array $fields
     * @param array $values
     * @return bool
     */
    public function insert($tableName, $fields, $values)
    {
        try {
            //"INSERT INTO users(fname,lname,created_at) VALUES(:fname,:lname,now())"  باید ساخته شود
            $stmt = $this->connection->prepare("INSERT INTO " . $tableName . "(" . implode(', ', $fields) . " , created_at)
             VALUES ( :" . implode(', :', $fields) . " , now() );");
            $stmt->execute(array_combine($fields, $values)); // array_combine از روش (:) رفتیم پس آرایه کلید دار می دهیم 
            return true;
        } catch (PDOException $e) {
            echo "<div style='color: red;'> There is some problem in connection f insert : </div>" . $e->getMessage();
            return false;
        }
    }
    /**
     * عملیات آبدیت
     *
     * @param string $tableName
     * @param string|int $id
     * @param array $fields
     * @param array $values
     * @return bool
     */
    public function update($tableName, $id, $fields, $values)
    {
        // "UPDATE `articles` SET `title`= ? , `cat_id`= ? , `summary`= ? , `updated_at`= now() WHERE `id` = ?" باید ساخته شود
        $sql = "UPDATE `" . $tableName . "` SET";
        foreach (array_combine($fields, $values) as $field => $value) {
            if ($value) {                               //not NULL -- اگر آن مقداری که می خواهی بزاری خالی نبود 
                $sql .= " `" . $field . "`= ? ,";
            } else {                                    // is "NULL" 
                $sql .= " `" . $field . "`=NULL,";
            }
        }
        $sql .= " `updated_at`= now()";
        $sql .= " WHERE `id` = ?";
        try {
            $stmt = $this->connection->prepare($sql);
            $affectedrows = $stmt->execute(array_merge(array_filter(array_values($values)), [$id]));
            if (isset($affectedrows)) {
                // echo "records are updated ";
            }
            return true;
        } catch (PDOException $e) {
            echo "<div style='color: red;'> There is some problem in f update : </div>" . $e->getMessage();
            return false;
        }
    }
    /**
     * عملیات حذف
     *
     * @param string $tableName
     * @param string|int $id
     * @return bool
     */
    public function delete($tableName, $id)
    {
        $sql = "DELETE FROM `" . $tableName . "`WHERE `id` = ? ;";
        try {
            $stmt = $this->connection->prepare($sql);
            $affectedrows = $stmt->execute([$id]); // be "excute" yek arayeh az id midahim
            if (isset($affectedrows)) {
                //echo "records are deleted ";
            }
            return true;
        } catch (PDOException $e) {
            echo "<div style='color: red;'> There is some problem in f delete : </div>" . $e->getMessage();
            return false;
        }
    }
    /**
     *  ساخت جداول دیتابیس 
     *
     * @param string $sql
     * @return bool
     */
    public function createTable($sql)
    {
        try {
            $this->connection->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "<div style='color: red;'> There is some problem in connection f createTable: </div>" . $e->getMessage();
            return false;
        }
    }
}
