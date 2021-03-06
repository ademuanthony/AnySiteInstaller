<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 7/13/2015
 * Time: 2:41 PM
 */

class Core_Model_Page extends Core_Model_Abstract_ModelBase {

    public function __construct($param = null){
        if(is_array($param) && count($param)){
            $key = $param[0];
            $this->getById($key);
        }
    }

    public function getById($key)
    {
        $key = strtolower($key);
        $sql = "select * from ".$this->getTableName()." where `permalink` = '$key'";
        $result = Core_Helper_Db::executeReader($sql);
        $this->copy($result);
    }

    public function setProperties($r)
    {
        // TODO: Implement setProperties() method.
        $this->Permalink = StringMethods::GetRaw($r->permalink);
        $this->Title = StringMethods::GetRaw($r->title);
        $this->Layout = StringMethods::GetRaw($r->layout);
        $this->Role = StringMethods::GetRaw($r->role);
        $this->Description = StringMethods::GetRaw($r->description);
        $this->Body = StringMethods::GetRaw($r->body);
        $this->Id = $r->id;
    }

    private function copy($result)
    {
        foreach ($result as $r) {
            $this->Permalink = StringMethods::GetRaw($r->permalink);
            $this->Title = StringMethods::GetRaw($r->title);
            $this->Layout = StringMethods::GetRaw($r->layout);
            $this->Role = StringMethods::GetRaw($r->role);
            $this->Description = StringMethods::GetRaw($r->description);
            $this->Body = StringMethods::GetRaw($r->body);
            $this->Id = $r->id;
        }
    }

    public  function getTableName(){
        return Core::getTableName('page');
    }

    public $Id;
    public $Permalink;
    public $Title;
    public $Layout;
    public $Role;
    public $Description;
    public $Body;

    public function Save(){
        $content = new Core_Model_Page([0=>$this->Permalink]);
        if($content->Id > 0 && $content->Id != $this->Id) {
            return 'A page with the same permalink already exist';
        }

        if(empty($this->Layout)) $this->Layout = 'page_default';

        $sql = !$this->Id > 0?"insert into ".$this->getTableName().
            "(`permalink`, `title`, `layout`, `role`, `description`, `body`) value('".StringMethods::MakeSave($this->Permalink).
            "', '".StringMethods::MakeSave($this->Title)."', '". StringMethods::MakeSave($this->Layout)."'
            , '". StringMethods::MakeSave($this->Role)."', '". StringMethods::MakeSave($this->Description)."',
             '". StringMethods::MakeSave($this->Body)."');"
            :"update ". $this->getTableName(). " set `title` = '".StringMethods::MakeSave($this->Title)."',
            layout = '". StringMethods::MakeSave($this->Layout). "', description = '". StringMethods::MakeSave($this->Description). "'
            , body = '". StringMethods::MakeSave($this->Body). "'
            where `permalink` = '".StringMethods::MakeSave($this->Permalink)."';";
        //die($sql);
        return Core_Helper_Db::executeNonQuery($sql);
    }

    public function Delete(){
        $sql = "delete * from ".$this->getTableName()." where permalink = '$this->Permalink'";
        return Core_Helper_Db::executeNonQuery($sql);
    }

    public static function GetAll($role = ''){
        $pageObj = new Core_Model_Page();
        $tableName = $pageObj->getTableName();
        $sql = "select * from $tableName".(empty($role)?';':" where role = '$role'");
        $results = Core_Helper_Db::executeReader($sql);
        $pages = array();
        foreach($results as $r){
            $page = new Core_Model_Page();
            $page->copy([$r]);
            $pages[] = $page;
        }
        return $pages;
    }
} 