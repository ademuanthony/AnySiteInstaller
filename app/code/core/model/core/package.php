<?php

/**
 * Created by PhpStorm.
 * User: ELACHI
 * Date: 5/15/2016
 * Time: 11:23 AM
 */
class Core_Model_Package extends Core_Model_Abstract_ModelBase
{
    const TABLE_PREFIX = 'packages';

    public function __construct(array $param = null)
    {
        $id = !empty($param) && isset($param[0]) ? $param[0] : -1;
        $this->getById($id);
    }

    public function setProperties($pdoObject){
        $this->Id = $pdoObject->id;
        $this->Title = $pdoObject->title;
        $this->ShortDescription = $pdoObject->shortDescription;
        $this->Description = $pdoObject->description;
        $this->Image = $pdoObject->image;
        $this->Keywords = $pdoObject->keywords;
        $this->CategoryId = $pdoObject->categoryId;
        $this->FileName = $pdoObject->fileName;
        $this->SortOrder = $pdoObject->sortOrder;
    }

    public function getTableName(){
        return Core::getTableName(self::TABLE_PREFIX);
    }

    public $Id;
    public $Title;
    public $ShortDescription;
    public $Description;
    public $CategoryId;
    public $Keywords;
    public $Image;
    public $FileName;
    public $SortOrder;


    public function Save(){
        $sql = "SELECT COUNT(*) AS no FROM ".$this->getTableName()." WHERE title = '".StringMethods::MakeSave($this->Title)
            ."' AND id <> '". StringMethods::MakeSave($this->Id). "';";
        $result = Core_Helper_Db::executeReader($sql);
        foreach ($result as $r) {
            if($r->no > 0){
                return 'A Package with the same title already exists';
            }
        }
        if($this->Id > 0){
            $sql = "update ".$this->getTableName()." set
            title = '".$this->Title."',
            shortDescription = '".$this->ShortDescription. "',
            description = '".$this->Description."',
            image = '".$this->Image."',
            keywords = '".$this->Keywords."',
            sortOrder = '".$this->SortOrder."',
            categoryId = '".$this->CategoryId."',
            fileName = '".$this->FileName."'
             where id = '".$this->Id."'";
        }else{
            $sql = "insert into " . $this->getTableName() . "(name, shortDescription, description, image, keywords, sortOrder, fileName, categoryId)
				 value('".StringMethods::MakeSave($this->Name)."',
				  '".StringMethods::MakeSave($this->ShortDescription)."',
				  '".StringMethods::MakeSave($this->Description)."',
				   '".StringMethods::MakeSave($this->Image)."',
				   '".StringMethods::MakeSave($this->Keywords)."',
				   '".StringMethods::MakeSave($this->SortOrder)."',
				   '".StringMethods::MakeSave($this->FileName)."',
				   '".StringMethods::MakeSave($this->CategoryId)."');";
        }

        //die($sql);
        return Core_Helper_Db::executeNonQuery($sql);

    }

    public function Delete(){
        $sql = "delete from " . $this->getTableName() . " where id = '".StringMethods::MakeSave($this->Id)."'";
        return Core_Helper_Db::executeNonQuery($sql);
    }

    public static function Count($categoryId = 0){
        $sql = "SELECT COUNT(*) AS no FROM ".Core::getTableName(self::TABLE_PREFIX);
        if($categoryId != 0)
            $sql .= " where categoryId = $categoryId";
        $result = Core_Helper_Db::executeReader($sql);
        foreach($result as $r){
            return $r->no;
        }
    }

    public static function GetPackages($offset, $limit, $categoryId = 0){
        $packages = array();
        $filter = $categoryId == 0? "": "where categoryId = $categoryId";
        $sql = "SELECT * FROM " . Core::getTableName(self::TABLE_PREFIX) . " $filter ORDER BY sortOrder DESC LIMIT $offset, $limit;";
        $result = Core_Helper_Db::executeReader($sql);
        foreach($result as $r){
            $package = new Core_Model_Package();
            $package->setProperties($r);
            $packages[] = $package;
        }
        return packages;
    }
}