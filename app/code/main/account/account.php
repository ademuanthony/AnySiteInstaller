<?php
/**
 * Created by Ademu Anthony.
 * User: Tony
 * Date: 3/21/2015
 * Time: 11:36 PM
 */

class Account extends Core_Abstract_Module_Controller {

    public function Index(){
        $this->data['pageTitle'] = 'Profile | ' . Core::getSystemSetting(Core::SITE_NAME);
        $this->data['user'] = $this->checkLogin();
        $this->data['transactions'] = $this->data['user']->GetTransactions();
        $this->data['payments'] = Core::getPaymentMethods();
        $this->renderTemplate();
    }

    public function Register($message = ''){

        if(isset($_POST['LoginId'])){
            $user = $this->loadModel('OpenSms_Model_User');
            if(strpos($_POST['LoginId'], '&') !== false){
                $this->setError('Username can not contain &', 'register_Account');
            }else{
                foreach($_POST as $key=>$value){
                    $user->{$key} = $value;
                }
                $user->Status = Core::OPEN_USER_STATUS_INACTIVE;
                $result = $user->save();
                if($result === true){
                    //create account
                    $account = $this->loadModel('Core_Model_Account');
                    $account->Number = $this->callModelStaticMethod('Core_Model_Account', 'GetAvailableNumber');
                    $account->LoginId = $this->getFormData('LoginId');
                    $account->Status = Core::OPEN_USER_STATUS_PENDING_APPROVAL;
                    $account->Save();
                    $this->setNotification('Your account registration was successful. It is now pending admin approval.
                    You will receive a message once its been approved',
                        'register_account');
                }else{
                    $this->setError($result, 'registration_error');
                }
            }

        }
        $this->data['pageTitle'] = "New Account | ".$this->getSystemSetting(Core::SITE_NAME);
        $this->renderTemplate();
    }

    public function Login(){
        if(isset($_REQUEST['LoginId'])){
            $user = $this->loadModel('OpenSms_Model_User', [0 => $_REQUEST['LoginId'], 1=> $_REQUEST['Password']]);
            if($user->IsValidated){
                $_SESSION['loginId'] = $user->LoginId;
                $_SESSION['role'] = $user->Role;
                if(isset($_REQUEST['callback'])){
                    echo $this->jsonp(array('error'=>FALSE, 'message'=> 'success', 'balance'=>$user->Balance, 'role'=> $user->Role));
                    exit();
                }
                Core::redirectToAction('index', 'dashboard', 'dashboard');
            }else{
                $errorMsg = 'Invalid Credential';
                if(isset($_REQUEST['callback'])){
                    echo jsonp(array('error'=>TRUE, 'message'=> $errorMsg, 'balance'=>0));
                    exit();
                }
                //OpenSms::redirectToAction('index', 'dashboard', 'dashboard');
            }
        }else{
            if(isset($_REQUEST['callback'])){
                echo $this->jsonp(array('error'=>TRUE, 'message'=> 'Invalid request param', 'balance'=>0));
                exit();
            }
            //die('Invalid request param');
        }

        $this->data['pageTitle'] = 'Login | '.Core::getSystemSetting(Core::SITE_NAME);
        $this->renderTemplate();
    }

    public function Logout(){
        unset($_SESSION['loginId']);
        unset($_SESSION['role']);
        Core::redirectToAction('index', 'home', 'home');
    }
} 