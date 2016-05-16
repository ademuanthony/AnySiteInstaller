<?php
/**
 * Created by Ademu Anthony.
 * User: Tony
 * Date: 4/9/2015
 * Time: 5:14 PM
 */

class Voucher extends Core_Abstract_Module_Controller{
    public function Index(){
        $this->data['pageTitle'] = 'Mange Voucher';
        $this->data['user'] = $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        if(isset($_REQUEST['no'])){
            $this->data['cards'] = Core::callModelStaticMethod('OpenSms_Model_Card', 'GenerateCard', [$_REQUEST['no'], $_REQUEST['unit']]);
        }

        $this->renderTemplate();
    }

    public function Add(){

    }
}