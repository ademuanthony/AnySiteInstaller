<?php

/**
 * Created by PhpStorm.
 * User: ELACHI
 * Date: 5/15/2016
 * Time: 11:03 AM
 */
class Core_Model_Category extends Core_Model_Abstract_ModelBase{

    const TABLE_PREFIX = 'categories';

    public function __construct(array $param = null)
    {
        $id = !empty($param) && isset($param[0]) ? $param[0] : -1;
        $this->getById($id);
    }

    public function setProperties($pdoObject){
        $this->Id = $pdoObject->id;
        $this->Name = $pdoObject->name;
        $this->ShortDescription = $pdoObject->shortDescription;
        $this->Description = $pdoObject->description;
        $this->Image = $pdoObject->image;
        $this->Keywords = $pdoObject->keywords;
    }

    public function getTableName(){
        return Core::getTableName(self::TABLE_PREFIX);
    }

    public $Id;
    public $Name;
    public $ShortDescription;
    public $Description;
    public $Image;
    public $Keywords;
    public $SortOrder;


    public function Save(){
        if($this->Id > 0){
            $sql = "update ".$this->getTableName()." set
            name = '".$this->Name."',
            shortDescription = '".$this->ShortDescription. "',
            description = '".$this->Description."',
            image = '".$this->Image."',
            keywords = '".$this->Keywords."',
            sortOrder = '".$this->SortOrder."'
             where id = '".$this->Id."'";
        }else{
            $sql = "insert into " . $this->getTableName() . "(name, shortDescription, description, image, keywords, sortOrder)
				 value('".StringMethods::MakeSave($this->Name)."',
				  '".StringMethods::MakeSave($this->ShortDescription)."',
				  '".StringMethods::MakeSave($this->Description)."',
				   '".StringMethods::MakeSave($this->Image)."',
				   '".StringMethods::MakeSave($this->Keywords)."',
				   '".StringMethods::MakeSave($this->SortOrder)."');";
        }

        //die($sql);
        return Core_Helper_Db::executeNonQuery($sql);

    }

    public function Delete(){
        $sql = "delete from " . $this->getTableName() . " where id = '".StringMethods::MakeSave($this->Id)."'";
        return Core_Helper_Db::executeNonQuery($sql);
    }

    public static function Count(){
        $sql = "SELECT COUNT(*) AS no FROM ".Core::getTableName(self::TABLE_PREFIX);
        $result = Core_Helper_Db::executeReader($sql);
        foreach($result as $r){
            return $r->no;
        }
    }

    public static function GetCategories(){
        $categories = array();
        $sql = "SELECT * FROM " . Core::getTableName(self::TABLE_PREFIX) . " ORDER BY sortOrder DESC";
        $result = Core_Helper_Db::executeReader($sql);
        foreach($result as $r){
            $category = new Core_Model_Category();
            $category->setProperties($r);
            $categories[] = $category;
        }
        return $categories;
    }
}