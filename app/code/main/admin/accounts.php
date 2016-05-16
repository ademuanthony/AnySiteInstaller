<?php

/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 4/10/2016
 * Time: 9:16 AM
 */
class Accounts extends Core_Abstract_Module_Controller
{

    public function Index($_page = 0, $status = Core::OPEN_USER_STATUS_ACTIVE){
        $this->data['user'] = $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        $this->data['pageTitle'] = 'Manage Accounts | '.Core::getSystemSetting(Core::SITE_NAME);
        $this->data['page'] = $_page;

        //########==paging==########//
        $rec_limit = 10;
        $count = $this->callModelStaticMethod('Core_Model_Account', 'Count', [0 => $status]);
        $no = ($count/$rec_limit);


        if($count%$rec_limit == 0)
        {
            $no -= 1;
        }
        $link = '<ul class="pagination">';
        for($i = 0; $i <= $no ; $i++)
        {
            if($i == ($_page - 1) || ($i == 0 && $_page == 0))
            {
                $link .= '<li class="active"><a href="#">Page '.($i + 1).'</a></li>';
            }
            else
            {
                $link .= '<li><a href="'.Core::getActionUrl('index', 'accounts', 'admin',
                        ['parameter1'=>($i + 1), 'parameter2' => $status]).'">Page '.($i + 1).'</a></li>';
            }
        }
        $link .= '</ul>';


        if($_page != 0)
        {
            $page = stripslashes($_page) - 1;
            $offset = $page * $rec_limit;
        }
        else
        {
            $page = 0;
            $offset = 0;
        }
        if($rec_limit == 0)
            $this->data['users'] = $this->callModelStaticMethod('Core_Model_Account', 'GetAccounts', [0=>$status]);
        else
            $this->data['users'] = $this->callModelStaticMethod('Core_Model_Account', 'GetAccounts', [0=>$status,
                1=>$offset, 2=>$rec_limit]);

        $this->data['page'] = $_page;
        $this->data['status'] = $status;
        $this->data['link'] = $link;
        $this->data['sn'] = $offset;
        //\paging

        $this->renderTemplate();
    }

    public function Add($_page = 0, $status = Core::OPEN_USER_STATUS_ACTIVE){
        //create login
        if(isset($_POST['LoginId'])){
            $user = $this->loadModel('OpenSms_Model_User');
            if(strpos($_POST['LoginId'], '&') !== false){
                $this->setError('Username can not contain &', 'register_Account');
            }else{
                foreach($_POST as $key=>$value){
                    $user->{$key} = $value;
                }
                $user->Status = Core::OPEN_USER_STATUS_ACTIVE;
                $result = $user->save();
                if($result === true){

                    //create account
                    $account = $this->loadModel('Core_Model_Account');
                    $account->Number = $this->getFormData('AccountNumber');
                    $account->LoginId = $this->getFormData('LoginId');
                    $account->Status = Core::OPEN_USER_STATUS_ACTIVE;
                    $result = $account->Save();
                    if($result === true){
                        $this->setNotification('Account created',
                            'register_account');
                        $this->redirectToAction('index');
                    }else{
                        $user->Delete();
                    }

                    $this->setError($result, 'registration_error');

                }else{
                    $this->setError($result, 'registration_error');
                }
            }

        }else{
            $this->setError('Invalid request param', 'registration_error');
        }
        $this->index($_page, $status);
    }

    public function find(){
        $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        if(isset($_GET['accountNumber'])){
            $this->redirectToAction('manage', '', '', [0=>urlencode($_GET['accountNumber'])]);
        }else{
            $this->redirectToAction('index', '', '', ['notification' => 'Invalid request param', 'page' => $_GET['page']]);
        }
        exit();
    }

    public function manage($accountNumber, $page){
        $this->data['user'] =  $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        $this->data['pageTitle'] = 'Manage Account | '.Core::getSystemSetting(Core::SITE_NAME);
        $this->data['page'] = $page;

        if(!empty($accountNumber)){
            $this->data['account'] = $this->callModelStaticMethod('Core_Model_Account', 'GetAccountByNumber', [0 => $accountNumber]);

            if(empty($this->data['account']->LoginId)){
                $this->setError('Invalid account number', 'account_manage');
                $this->redirectToAction('index', 'accounts', 'admin', [0 => $page]);
            }
            $this->data['curUser'] = $this->data['account']->getUser();
            $this->data['transactions'] = $this->data['account']->getTransactions(0, 1000);
        }

        if(!isset($this->data['account']) || !isset($this->data['account']->LoginId)){
            $this->setError('No account to show', 'manage_users');
            //$this->data['curUser'] = $this->loadModel('OpenSms_Model_User');
            $this->redirectToAction('index');
        }


        $this->renderTemplate();

    }

    public function activate($accountId, $page){
        $account = $this->loadModel('Core_Model_Account', [0 => $accountId]);
        $user = $account->getUser();
        $account->Status = Core::OPEN_USER_STATUS_ACTIVE;
        $user->Status = Core::OPEN_USER_STATUS_ACTIVE;
        $account->Save();
        $user->Save();
        die('here');
        $this->setNotification('Account Activated', 'accounts_activate');
        return $this->redirectToAction('manage', 'accounts', 'admin', [0 => $accountId, 1 => $page]);
    }

    public function saveTransaction($accountNumber, $page){
        $user = $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        $account = $this->callModelStaticMethod('Core_Model_Account', 'GetAccountByNumber', [0 => $accountNumber]);
        if($this->getFormData('Type') == Core::OPEN_TRANSACTION_TYPE_CREDIT){
            $deposit = $this->loadModel('Core_Model_Deposit');
            $deposit->AccountId = $account->Id;
            $deposit->Amount = $this->getFormData('Amount');
            $deposit->CashierLoginId = $user->LoginId;
            $deposit->Status = $this->getFormData('Status');
            $result = $deposit->Save();
            if($result === true){
                $this->setNotification('Deposit succeeded', 'account_saveTransaction');
            }else{
                $this->setError($result, 'account_saveTransaction');
            }
        }else{
            $deposit = $this->loadModel('Core_Model_Withdrawal');
            $deposit->AccountId = $account->Id;
            $deposit->Amount = $this->getFormData('Amount');
            $deposit->CashierLoginId = $user->LoginId;
            $deposit->Status = $this->getFormData('Status');
            $result = $deposit->Save();
            if($result === true){
                $this->setNotification('Withdrawal succeeded', 'account_saveTransaction');
            }else{
                $this->setError($result, 'account_saveTransaction');
            }
        }
        $this->redirectToAction('Manage', '', '', ['parameter1' => $accountNumber, 'parameter2' => $page]);
    }

    public function update($_loginId){
        $this->data['user'] =  $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        //editing
        if(isset($_POST['resetPassword'])){
            $errorMsg = '';
            //validation
            if(trim($_POST['Password']) == '' ){
                $this->setError('Password cannot be empty and password must match', 'users_update');
                $error_code = 1;
            }
            else{
                $user= $this->loadModel('OpenSms_Model_User', [0=>$_loginId]);
                $user->Password = $_POST['Password'];
                $user->Save();

                $this->setNotification('Password Changed', 'users_update');
                $error_code = 0;
            }

        }else{
            $this->setError('Invalid request param', 'users_update');
        }

        Core::redirectToAction('manage', 'users', 'admin', [0=>$_loginId], $error_code);
        //header('Location: '.URL.'users?notification='.$errorMsg.'&error_code='.$error_code);
        //exit();

    }

    public function recharge(){
        $curUser =  $this->checkLogin('enekpani');
        $user = new User($_POST['loginId']);
        //crediting account

        if(isset($_POST['creditaccount'])){
            $errorMsg = '';

            //validation
            if(trim($_POST['qnt']) == '' || $_POST['qnt'] < 1){
                $errorMsg = 'You must specify the quantity and it must not be less than one';
            }


            if($errorMsg == ''){
                if($_POST['transType'] == 'credit'){
                    ////check if admin have enogh
                    //if($curUser->Balance )
                    $user->Balance += $_POST['qnt'];
                    $qnt = abs($_POST['qnt']);
                    //$curUser->Balance -= $_POST['qnt'];
                }
                else{
                    if($user->Balance >= $_POST['qnt']){
                        $user->Balance -= $_POST['qnt'];
                        $qnt = (-abs($_POST['qnt']));
                        //$curUser->Balance += $_POST['qnt'];
                    }else{
                        $errorMsg = $user->Name.' do not have up to '.$_POST['qnt'].' units';
                    }
                }


                if($errorMsg == ''){
                    $success = $this->deductAccount($qnt);
                    if($success){
                        //if($curUser->LoginId != $user->LoginId){
                        //    $curUser->Save();
                        //}
                        $user->Save();
                        $errorMsg = 'Transaction saved';
                    }else{
                        $errorMsg = "Low master account balance";
                    }
                }
            }
        }
        $error_code = $errorMsg == 'Transaction saved'?0:1;
        header('Location: '.URL.'users/manage/'.$_POST['loginId'].'?notification='.$errorMsg.'&error_code='.$error_code);
        exit();
    }

    public function delete($accountNumber, $page){
        $this->checkLogin('enekpani');

        //deleting account
        if(!empty($accountNumber)){
            $account = $this->loadModel('Core_Model_Account', [0 => $accountNumber]);
            $account->Delete();
            $notification = 'Account Deleted';
            $this->setNotification($notification, 'delete_account');
        }else{
            $this->setError('Invalid request param', 'delete_account');
        }

        $this->redirectToAction('index', '', '', ['parameter1' => $page]);
        exit();
    }

}