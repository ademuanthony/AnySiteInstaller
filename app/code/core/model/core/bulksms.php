<?php
    class Core_Model_BulkSms extends Core_Model_Abstract_ModelBase{

        public function __construct(array $param = null)
        {
            $id = !empty($param) && isset($param[0]) ? $param[0] : -1;
            $this->getById($id);
        }


        public function setProperties($r){
            $this->LoginId = $r->loginId;
            $this->Sender = $r->sender;
            $this->Message = $r->message;
            $this->Count = $r->count;
            $this->Id = $r->id;
            $this->DateCreated = $r->dateCreated;
            $this->Status = $r->status;
        }

        public function getTableName(){
            return Core::getTableName('bulksms');
        }

        public $Id;
        public $LoginId;
        public $Sender;
        public $Message;
        public $Count;
        public $DateCreated;
        public $Status;
        
		public function Save(){
			$sql = "insert into " . Core::getTableName('bulksms') . "(loginId, message, sender, status, count)
				 value('".StringMethods::MakeSave($this->LoginId)."', '".StringMethods::MakeSave($this->Message)."', '".
                 StringMethods::MakeSave($this->Sender)."', '".StringMethods::MakeSave($this->Status)."', '".$this->Count."');";
                 //die($sql);
			Core_Helper_Db::executeNonQuery($sql);
			
			if($this->Id == -1){
				$sql = "select MAX(id) as no from `" . Core::getTableName('bulksms') . "`";
				$result = Core_Helper_Db::executeReader($sql);
				foreach($result as $r){
					$this->Id = $r->no;
					return $r->no;
				}
			}
		}
		
		public function Delete(){
			$sql = "delete from " . Core::getTableName('bulksms') . " where id = '".StringMethods::MakeSave($this->Id)."'";
			return Core_Helper_Db::executeNonQuery($sql);
		}

        public function SaveMessages($messages){
			$sql = 'insert into ' . Core::getTableName('sms') . '(bulkSMSId, number, message, sender, refId, status) value';
			$i = 0;
			foreach($messages as $message){
				$i += 1;
				$count = count($messages);
				$sql .= "('".StringMethods::MakeSave($message->BulkSMSId)."', '".StringMethods::MakeSave($message->Number)."', '".
                 StringMethods::MakeSave($message->Message)."', '".StringMethods::MakeSave($message->Sender)."', '".
                 StringMethods::MakeSave($message->RefId)."', '".StringMethods::MakeSave($message->Status)."')";
				if($i == $count)
					$sql.=';';
				else
					$sql.=',';
			}
			Core_Helper_Db::executeNonQuery($sql);
		}

        function GetRecipients(){
            $sql = "select number from " . Core::getTableName('sms') . " where bulkSMSId = '".$this->Id."';";
            $result = Core_Helper_Db::executeReader($sql);
            $numbers = '';
            foreach($result as $r){
                $numbers .= StringMethods::GetRaw($r->number).',';
            }
            return substr($numbers, 0, strlen($numbers) - 1);
        }

        function GetMessages(){
            $sql = "select * from " . Core::getTableName('sms') . " where bulkSMSId = '".$this->Id."';";
            $result = Core_Helper_Db::executeReader($sql);
            $messages = array();
            foreach($result as $r){
                $message = Core::loadModel('OpenSms_Model_Message');
                $message->Id = StringMethods::GetRaw($r->id);
                $message->BulkSMSId = StringMethods::GetRaw($r->bulkSMSId);
                $message->Number = StringMethods::GetRaw($r->number);
                $message->Message = StringMethods::GetRaw($r->message);
                $message->Sender = StringMethods::GetRaw($r->sender);
                $message->RefId = StringMethods::GetRaw($r->refId);
                $message->Status = StringMethods::GetRaw($r->status);
                $messages[] = $message;
            }
            return $messages;
        }

        public static function GetBulkSMSCount($loginId){
            $sql = "select count(*) as no from " . Core::getTableName('bulksms') . " where loginId = '$loginId';";
            $result = Core_Helper_Db::executeReader($sql);
            foreach($result as $r){
                return $r->no;
            }
            return 0;
        }

        public static function GetBulkSMS($loginId, $offset, $limit){
            $bulkSMSs = array();
            $sql = "select * from " . Core::getTableName('bulksms') . " where loginId = '$loginId' ORDER BY id DESC LIMIT $offset, $limit;";
            $result = Core_Helper_Db::executeReader($sql);
            foreach($result as $r){
                $bulkSMS = new Core_Model_BulkSms();
                $bulkSMS->Id = $r->id;
                $bulkSMS->LoginId = StringMethods::GetRaw($r->loginId);
                $bulkSMS->DateCreated = $r->dateCreated;
                $bulkSMS->Message = StringMethods::GetRaw($r->message);
                $bulkSMS->Sender = StringMethods::GetRaw($r->sender);
                $bulkSMS->Status = StringMethods::GetRaw($r->status);
                $bulkSMS->Count = $r->count;
                $bulkSMSs[] = $bulkSMS;
            }
            return $bulkSMSs;
        }
    }
?>