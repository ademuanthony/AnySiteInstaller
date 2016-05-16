<?php
    class Core_Model_User extends Core_Model_Abstract_ModelBase{

        const ADMIN = 'enekpani';

        const SMS_USER = 'user';

        public function getTableName(){
            return Core::getTableName('users');
        }

		public function __construct(array $param = null){
            $loginId = $param == null || empty($param[0])? "" : $param[0];
            $_password = $param == null || empty($param[1])? "" : $param[1];

			$this->IsOld = false;
			$this->Balance = 0;
			 if($loginId != ''){
				$sql = "select * from ".$this->getTableName()." where loginId = '".StringMethods::MakeSave($loginId)."' ".
                    (!empty($_password)?"and status = 'active';": ";");
						
				//die($sql);
				$result = Core_Helper_Db::executeReader($sql);
				foreach($result as $r){
					if($_password != '') $this->IsValidated = self::Validate($loginId, $_password);
					$this->IsOld = true;
					$this->Name = StringMethods::GetRaw($r->name);
					$this->LoginId = StringMethods::GetRaw($r->loginId);
					$this->Address = StringMethods::GetRaw($r->address);
					$this->DateRegistered = StringMethods::GetRaw($r->dateRegistered);
                    $this->BillingAddress1 = StringMethods::GetRaw($r->billing_address1);
                    $this->BillingAddress2 = StringMethods::GetRaw($r->billing_address2);
                    $this->BillingCity = StringMethods::GetRaw($r->billing_city);
                    $this->BillingState = StringMethods::GetRaw($r->billing_state);
                    $this->BillingCountry = StringMethods::GetRaw($r->billing_country);
					$this->Balance = $r->balance;
					$this->EmailId = StringMethods::GetRaw($r->emailId);
					$this->MobileNo = StringMethods::GetRaw($r->mobileNo);
                    $this->Role = StringMethods::GetRaw($r->role);
					
				}

                 /*
                if(!$this->IsValidated){
                    $this->getUserFromJ($loginId, $_password);
                }
                 */
			 }
		}

        public function setProperties($pdoObj){
            $this->Address = $pdoObj->address;
            $this->Balance = $pdoObj->balance;
            $this->DateRegistered = $pdoObj->dateRegistered;
            $this->EmailId = $pdoObj->emailId;
            $this->IsOld = true;
            $this->LoginId = $pdoObj->loginId;
            $this->MobileNo = $pdoObj->mobileNo;
            $this->Name = $pdoObj->name;
            $this->Role = $pdoObj->role;
            $this->Status = $pdoObj->status;
            $this->BillingCountry = $pdoObj->billing_country;
            $this->BillingAddress2 = $pdoObj->billing_address2;
            $this->BillingAddress1 = $pdoObj->billing_address1;
            $this->BillingCity = $pdoObj->billing_city;
            $this->BillingState = $pdoObj->billing_state;
        }

        public function getById($username){
            return self::FindUserById($username);
        }

		public $LoginId;
		
		public $Password;
		
		public $Name;

        public $Image;
		
		public $Address;
		
		public $MobileNo;
		
		public $EmailId;
		
		public $DateRegistered;

        public $BillingAddress1;

        public $BillingAddress2;

        public $BillingCity;

        public $BillingState;

        public $BillingCountry;
		
		public $Balance;
		
        public $Role;

        public $Status;

		public $IsOld;
		
		public $IsValidated;
						
		public function Save(){
			if($this->IsOld){
				if($this->Password != '')
					$sql = "update ".$this->getTableName()." set password = '".StringMethods::Encode("$this->Password")."',
                    role = '".StringMethods::MakeSave("$this->Role")."', balance = '".StringMethods::MakeSave(
					$this->Balance)."' where loginId = '".StringMethods::MakeSave($this->LoginId)."';";
				else
					$sql = "update ".$this->getTableName()." set
					balance = '".StringMethods::MakeSave($this->Balance)."',
                    role = '".StringMethods::MakeSave("$this->Role")."', status = '".$this->Status."'
                    where loginId = '".StringMethods::MakeSave($this->LoginId)."';";
			}else{
				//validate
				$u = self::FindUserById($this->LoginId);
				if(isset($u->LoginId)){
					return 'The selected username is in use';	
				}
				
				$u = self::FindUserByEmail($this->EmailId);
				if(isset($u->LoginId)){
					return 'The selected Email Address is in use';	
				}
				
                if(empty($this->MobileNo)){
                    
                }
				$u = self::FindUserByPhoneNumber($this->MobileNo);
				if(isset($u->LoginId)){
					return 'The selected phone number is in use';	
				}
				
				
				$sql = "insert into ".Core::getTableName('users')."(loginId, password, name, address, mobileNo, emailId, balance, role, status)
				 value('".StringMethods::MakeSave($this->LoginId)."', '".StringMethods::Encode("$this->Password")."', 
                 '".StringMethods::MakeSave($this->Name)."', 
                 '".StringMethods::MakeSave($this->Address)."', '".StringMethods::MakeSave($this->MobileNo).
                 "', '".StringMethods::MakeSave($this->EmailId)."', '$this->Balance',
                  '".($this->Role == self::ADMIN?$this->Role:self::SMS_USER)."', '".$this->Status. "');";
			}
			
			//die($sql);
            return Core_Helper_Db::executeNonQuery($sql);
		}

        public function UpdateBillingInfo(){
            $sql = "update ".$this->getTableName()." set billing_address1 = '".StringMethods::MakeSave($this->BillingAddress1)."',
                    billing_address2 = '".StringMethods::MakeSave($this->BillingAddress2)."',
                    billing_city = '".StringMethods::MakeSave($this->BillingCity)."',
                    billing_state = '".StringMethods::MakeSave($this->BillingState)."',
                    billing_country = '".StringMethods::MakeSave($this->BillingCountry)."'
                    where loginId = '".StringMethods::MakeSave($this->LoginId)."';";
            return Core_Helper_Db::executeNonQuery($sql);
        }

        public function Delete(){
			$sql = "update ".$this->getTableName()." set status = 'deleted' where loginId = '".StringMethods::MakeSave($this->LoginId)."'";
			//die($sql);
            return Core_Helper_Db::executeNonQuery($sql);
		}

        public function GetTransactions(){
            $trans = array();
            if(empty($this->LoginId)) return $trans;

            $sql = "select * from ".Core::getTableName('transactions')." where loginId = '".StringMethods::MakeSave($this->LoginId)."'";

            $result = Core_Helper_Db::executeReader($sql);

            foreach($result as $tran){
                $trans[] = Core::callModelStaticMethod('OpenSms_Model_Transaction', 'copyFromPDO', [0 => $tran]);
            }
            return $trans;
        }

        public function GetLastTransaction(){
            $trans = array();
            if(empty($this->LoginId)) return $trans;

            $sql = "select * from ".Core::getTableName('transactions')." where loginId =
            '".StringMethods::MakeSave($this->LoginId)."' and id = (select MAX(id) from ".Core::getTableName('transactions')."
            where loginId = '".StringMethods::MakeSave($this->LoginId)."')";

            $result = Core_Helper_Db::executeReader($sql);

            foreach($result as $tran){
                return Core::callModelStaticMethod('OpenSms_Model_Transaction', 'copyFromPDO', [0 => $tran]);
            }
            return Core::loadModel('OpenSms_Model_Transaction');
        }
		
		public function GetGroups(){
			$groups = array();
			$sql = "select * from `".Core::getTableName('group')."` where loginId = '".StringMethods::MakeSave($this->LoginId)."' ORDER BY `id` DESC";
						
			$result = Core_Helper_Db::executeReader($sql);

            foreach($result as $r){
                $g = Core::loadModel("OpenSms_Model_Group");
                $g->Id = $r->id;
                $g->Name = $r->name;
                $g->LoginId  = $r->loginId;
                $g->Description = $r->description;
                $g->GroupExits = !empty($r->id);

                $groups[] = $g;
            }

			return $groups;
		}
		
		public function GetDrafts(){
			$drafts = array();
			$db = new TDataAccess();
			$sql = "select * from `draft` where loginId = '".StringMethods::MakeSave($this->LoginId)."' and deliveryType = 'draft'";
						
			$result = Core_Helper_Db::executeNonQuery($sql);

            foreach ($result as $d) {
                $drafts[] = OpenSms_Model_Draft::copyFromPDO($d);
            }

			return $drafts;
		}
		
        public function GetSentMessages(){
			$drafts = array();
			$db = new TDataAccess();
			$sql = "select * from `draft` where loginId = '".StringMethods::MakeSave($this->LoginId)."' and deliveryType = 'sent'";
						
			$result = Core_Helper_Db::executeNonQuery($sql);

            foreach ($result as $d) {
                $drafts[] = OpenSms_Model_Draft::copyFromPDO($d);
            }

			return $drafts;
		}

        public function GetScheduledMessages(){
			$drafts = array();
			$sql = "select * from `draft` where loginId = '".StringMethods::MakeSave($this->LoginId)."' and deliveryType = 'scheduled'";
						
			$result = Core_Helper_Db::executeNonQuery($sql);

            foreach ($result as $d) {
                $drafts[] = OpenSms_Model_Draft::copyFromPDO($d);
            }

			return $drafts;
		}

        public static function copyFromPDO($pdoObj){
            $u = new Core_Model_User();
            $u->Address = $pdoObj->address;
            $u->Balance = $pdoObj->balance;
            $u->DateRegistered = $pdoObj->dateRegistered;
            $u->EmailId = $pdoObj->emailId;
            $u->IsOld = true;
            $u->LoginId = $pdoObj->loginId;
            $u->MobileNo = $pdoObj->mobileNo;
            $u->Name = $pdoObj->name;
            $u->Role = $pdoObj->role;
            $u->Status = $pdoObj->status;
            $u->BillingCountry = $pdoObj->billing_country;
            $u->BillingAddress2 = $pdoObj->billing_address2;
            $u->BillingAddress1 = $pdoObj->billing_address1;
            $u->BillingCity = $pdoObj->billing_city;
            $u->BillingState = $pdoObj->billing_state;

            return $u;
        }

        public static function GetAllUsers($offset = 0, $limit = 0)
        {
            if ($limit == 0) {
                $sql = "select * from " . Core::getTableName('users') . " where status = 'active'";
            } else {
                $sql = "select * from " . Core::getTableName('users') . " where status = 'active' ORDER BY LoginId LIMIT $offset, $limit";
            }
            $users = array();
            $result = Core_Helper_Db::executeReader($sql);
            foreach ($result as $u) {
                $users[] = self::copyFromPDO($u);
            }

            return $users;
        }

        public static function GetInactiveUsers($offset = 0, $limit = 0)
        {
            if ($limit == 0) {
                $sql = "select * from " . Core::getTableName('users') . " where status = '". Core::OPEN_USER_STATUS_INACTIVE. "'";
            } else {
                $sql = "select * from " . Core::getTableName('users') . " where status = '".
                    Core::OPEN_USER_STATUS_INACTIVE. "' ORDER BY LoginId LIMIT $offset, $limit";
            }
            $users = array();
            $result = Core_Helper_Db::executeReader($sql);
            foreach ($result as $u) {
                $users[] = self::copyFromPDO($u);
            }

            return $users;
        }

        public static function Count($status){
            $sql = 'select count(*) as no from '.Core::getTableName('users') . " where status = '$status'";

            $result = Core_Helper_Db::executeReader($sql);
            foreach($result as $r)
                return $r->no;
        }

		public static function Validate($loginId, $password)
        {
            $sql = "select count(*) as no from ".Core::getTableName('users')." where loginId = '" .
                StringMethods::MakeSave($loginId) . "' && password = '" . StringMethods::Encode($password) . "';";

            $result = Core_Helper_Db::executeReader($sql);

            if (!isset($result[0])) return false;

            return $result[0]->no == 1;
        }
		
		public static function FindUserById($loginId){
			$sql = "select * from ".Core::getTableName('users')." where loginId = '".StringMethods::MakeSave($loginId)."';";
            $result = Core_Helper_Db::executeReader($sql);
            $u = isset($result[0])?self::copyFromPDO($result[0]):new Core_Model_User();
            return $u;
		}

        public static function FindUserByPhoneNumber($mobileNo){
            $sql = "select * from ".Core::getTableName('users')." where loginId = '".StringMethods::MakeSave($mobileNo)."';";
            $u = new Core_Model_User();
            $result = Core_Helper_Db::executeReader($sql);

            return isset($result[0])?self::copyFromPDO($result[0]):new Core_Model_User();
        }

        public static function FindUserByEmail($emailId){
            $sql = "select * from ".Core::getTableName('users')." where loginId = '".StringMethods::MakeSave($emailId)."';";
            $u = new Core_Model_User();
            $result = Core_Helper_Db::executeReader($sql);

            return isset($result[0])?self::copyFromPDO($result[0]):new Core_Model_User();
        }

        public static function getMobileNos(){
            $sql = "select mobileNo from users where mobileNo <> ''";
            $result = Core_Helper_Db::executeReader($sql);
            $nos = '';

		    foreach($result as $r){
                $fChar = substr($r->mobileNo, 0, 1);
                if(trim($r->mobileNo) != '' && ($fChar == '2' || $fChar == '0' || $fChar == '8')){
                    $nos .= trim($r->mobileNo).',';
                }
            }
            return $nos;
        }
	}