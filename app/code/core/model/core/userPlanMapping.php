<?php

/**
 * Created by PhpStorm.
 * User: ELACHI
 * Date: 5/15/2016
 * Time: 12:00 PM
 */

class Core_Model_UserPlanMapping extends Core_Model_Abstract_ModelBase{

    const TABLE_PREFIX = 'userPlanMappings';

    public function __construct(array $param = null)
    {
        $id = !empty($param) && isset($param[0]) ? $param[0] : -1;
        $this->getById($id);
    }

    public function setProperties($pdoObject){
        $this->Id = $pdoObject->id;
        $this->LoginId = $pdoObject->loginId;
        $this->PlanId = $pdoObject->planId;
    }

    public function getTableName(){
        return Core::getTableName(self::TABLE_PREFIX);
    }

    public $Id;
    public $LoginId;
    public $PlanId;


    public function Save(){

        if($this->Id > 0){
            $sql = "update ".$this->getTableName()." set
            planId = '".$this->PlanId."'
             where id = '".$this->Id."'";
        }else{
            if(self::GetPlanByLoginId($this->LoginId)){
                return 'This package has already been added to a plan';
            }
            $sql = "insert into " . $this->getTableName() . "(loginId, planId)
				 value('".StringMethods::MakeSave($this->LoginId)."',
				  '".StringMethods::MakeSave($this->PlanId)."'
				  );";
        }

        //die($sql);
        return Core_Helper_Db::executeNonQuery($sql);

    }

    public function Delete(){
        $sql = "delete from " . $this->getTableName() . " where id = '".StringMethods::MakeSave($this->Id)."'";
        return Core_Helper_Db::executeNonQuery($sql);
    }


    public function GetPlanByLoginId($loginId){
        $mapping = null;
        $sql = "SELECT * FROM ".Core::getTableName(self::TABLE_PREFIX)." WHERE loginId = $loginId";
        $result = Core_Helper_Db::executeReader($sql);
        foreach ($result as $r) {
            $mapping = new Core_Model_PackagePlanMapping();
            $mapping->setProperties($r);
        }
        if($mapping == null) return null;
        return Core::loadModel('Core_Model_Plan', array(0 => $mapping->PlanId));
    }
}