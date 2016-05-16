<?php
    
	class Core_Model_Contact extends Core_Model_Abstract_ModelBase{
		
		public function __construct(array $param = [0 => -1]){
            $this->getById(isset($param[0]) ? $param[0] : -1);
		}

        public function getById($id = -1){
            $this->Id = $id;
            if($id != ''){
                $sql = "select * from ".Core::getTableName('contact')." where id = '".StringMethods::MakeSave($id)."';";
                $result = Core_Helper_Db::executeReader($sql);
                foreach($result as $r){
                    $this->GroupId = $r->groupId;
                    $this->Name = StringMethods::GetRaw($r->name);
                    $this->Number = StringMethods::GetRaw($r->number);
                    $this->Id = $r->id;
                }
            }
        }

        public function getTableName(){
            return Core::getTableName('contact');
        }

		public $Id;
		
		public $GroupId;
		
		public $Number;
		
		public $Name;
		
		public static function SaveContacts($contacts){
			$sql = 'insert into '.Core::getTableName('contact').'(groupId, number, name) values';
			$i = 0;
			foreach($contacts as $con){
                if(empty($con->Number)){
                    continue;
                }
				$i += 1;
				$count = count($contacts);
				$sql .= "('".
				StringMethods::MakeSave($con->GroupId)."', '".StringMethods::MakeSave($con->Number)."', '".StringMethods::MakeSave($con->Name)."')";
				if($i == $count)
					$sql.=';';
				else
					$sql.=',';
			}
            return Core_Helper_Db::executeNonQuery($sql);
		}
		
		public function Save(){
			if($this->Id != -1){
				$sql = "update ".Core::getTableName('contact')." set groupId = '".StringMethods::MakeSave($this->GroupId)
                ."', number = '".StringMethods::MakeSave($this->Number)."', name = '".StringMethods::MakeSave($this->Name).
				"' where id = '$this->Id';";
			}else{
				$sql = "insert into draft(groupId, number, name) value('".
				StringMethods::MakeSave($this->GopupId)."', '".StringMethods::MakeSave($this->Number)."', '.".StringMethods::MakeSave($this->name)."');";
			}
            return Core_Helper_Db::executeNonQuery($sql);
		}
		
		public function Delete(){
			$sql = "delete from ".Core::getTableName('contact')." where id = '".StringMethods::MakeSave($this->Id)."'";
            //die($sql);
			if(Core_Helper_Db::executeNonQuery($sql)){
			    return 'One number deleted';
			}else
                return 'Error in deleting number';
		}
			
	}
?>