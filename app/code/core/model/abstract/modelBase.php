<?php
abstract class Core_Model_Abstract_ModelBase{

    public static function  getDb()
    {
        return Core_Helper_Db::getClassDb();
    }

    public $Id;

    public abstract function getTableName();
    public abstract function setProperties($pdoObject);


    public function getById($id)
    {
        $this->Id = $id;
        if ($id != -1) {
            $sql = "select * from " . $this->getTableName() . " where id = '$id';";
            $result = Core_Helper_Db::executeReader($sql);
            foreach ($result as $r) {
                $this->setProperties($r);
            }
        }
    }


    public function Delete(){
        $sql = "delete from " . $this->getTableName() . " where id = '".StringMethods::MakeSave($this->Id)."'";
        return Core_Helper_Db::executeNonQuery($sql);
    }

}