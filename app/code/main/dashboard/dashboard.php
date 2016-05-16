<?php
/**
 * Created by Ademu Anthony.
 * User: Tony
 * Date: 3/23/2015
 * Time: 9:26 AM
 */

class Dashboard extends Core_Abstract_Module_Controller {
    public function Index(){
        $this->getCurrentUri();
        $user = $this->checkLogin();
        $this->data['user'] = $user;
        $this->data['transactions'] = $user->GetTransactions();

       // $this->data['account'] = $this->callModelStaticMethod('Core_Model_Account', 'GetAccountByLoginId', [0 => $user->LoginId]);

        $this->data['curUser'] = $user;

        $this->data['pageTitle'] = 'Dashboard | '.Core::getSystemSetting(Core::SITE_NAME);
        $this->renderTemplate('body');
    }

    public function SendMoney(){
        $user = $this->checkLogin();
        $account = $this->callModelStaticMethod('Core_Model_Account', 'GetAccountByLoginId', [0 => $user->LoginId]);
        $toAccount = $this->callModelStaticMethod('Core_Model_Account', 'GetAccountByNumber', [0 => $this->getFormData('AccountNumber')]);

        if($account->Id == $toAccount->Id){
            $this->setError('You cannot transfer to yourself', 'sendMoney_dashboard');
            $this->redirectToAction('Index');
        }
        if(empty($toAccount) || empty($toAccount->LoginId)){
            $this->setError('Invalid account number', 'sendMoney_dashboard');
            $this->redirectToAction('Index');
        }
        $accountBalance = $account->GetBalance();
        if($accountBalance < $this->getFormData('Amount')){
            $this->setError("You cannot send more than $accountBalance", "sendMoney_dashboard");
            $this->redirectToAction('Index');
        }
        $transfer = $this->loadModel('Core_Model_Transfer');
        $transfer->FromAccountId = $account->Id;
        $transfer->ToAccountId = $toAccount->Id;
        $transfer->Amount = $this->getFormData('Amount');
        $transfer->Status = Core::OPEN_TRANSACTION_STATUS_COMPLETED;
        $result = $transfer->Save();
        if($result === true){
            $this->setNotification('Transfer succeeded', 'sendMoney');
        }else{
            $this->setError($result, 'sendMoney_dashboard');
        }
        $this->redirectToAction('Index');

    }
} 