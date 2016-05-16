<?php

/**
 * Created by PhpStorm.
 * User: ELACHI
 * Date: 5/15/2016
 * Time: 11:48 AM
 */


class Core_Model_PackagePlanMapping extends Core_Model_Abstract_ModelBase{

    const TABLE_PREFIX = 'packagePlanMappings';

    public function __construct(array $param = null)
    {
        $id = !empty($param) && isset($param[0]) ? $param[0] : -1;
        $this->getById($id);
    }

    public function setProperties($pdoObject){
        $this->Id = $pdoObject->id;
        $this->PackageId = $pdoObject->packageId;
        $this->PlanId = $pdoObject->planId;
    }

    public function getTableName(){
        return Core::getTableName(self::TABLE_PREFIX);
    }

    public $Id;
    public $PackageId;
    public $PlanId;

    public function Save(){

        if($this->Id > 0){
            $sql = "update ".$this->getTableName()." set
            planId = '".$this->PlanId."'
             where id = '".$this->Id."'";
        }else{
            if(self::GetPlanByPackageId($this->PackageId)){
                return 'This package has already been added to a plan';
            }
            $sql = "insert into " . $this->getTableName() . "(packageId, planId)
				 value('".StringMethods::MakeSave($this->PackageId)."',
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


    public function GetPlanByPackageId($packageId){
        $mapping = null;
        $sql = "SELECT * FROM ".Core::getTableName(self::TABLE_PREFIX)." WHERE packageId = $packageId";
        $result = Core_Helper_Db::executeReader($sql);
        foreach ($result as $r) {
            $mapping = new Core_Model_PackagePlanMapping();
            $mapping->setProperties($r);
        }
        if($mapping == null) return null;
        return Core::loadModel('Core_Model_Plan', array(0 => $mapping->PlanId));
    }
}