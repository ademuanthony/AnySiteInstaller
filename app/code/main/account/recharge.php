<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 4/4/2015
 * Time: 3:08 PM
 */

class Recharge extends Core_Abstract_Module_Controller{
    public function Index(){
        $this->data['user'] = $this->checkLogin();
        $this->data['pageTitle'] = 'But Unit';

        $this->data['payments'] = Core::getPaymentMethods();


        $this->renderTemplate();
    }

    public function Save(){
        $user = $this->checkLogin();
        //create a transaction
        $trans = $this->loadModel("OpenSms_Model_Transaction");
        foreach($_POST as $key=>$value){
            $trans->{$key} = $value;
        }

        $trans->Unit = $trans->Amount/Core::getSystemSetting(Core::OPEN_PRICE_PER_UNIT);

        $trans->LoginId = $user->LoginId;
        //get the selected payment
        $payment = Core::getPaymentMethod($_POST['PaymentMethod'], true);

        //var_dump($payment); die();

        //set the order status to that of the payment method
        $trans->Status = $payment->order_status;
        $trans->Type = Core::OPEN_TRANSACTION_TYPE_CREDIT;
        //save the order
        $trans->Save();
        //put the transaction in session
        $_SESSION[Core::LAST_TRANSACTION] = $trans;
        //make payment
        $paymentController = new $payment->controller();
        $paymentController->{$payment->action}();

    }

    public function Success(){

    }

    public function Failure(){

    }


} 