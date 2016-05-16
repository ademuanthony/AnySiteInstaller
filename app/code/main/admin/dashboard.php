<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 3/20/2015
 * Time: 10:56 AM
 */

class dashboard extends Core_Abstract_Module_Controller{
    public function index(){
        $this->data['user'] = $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        $this->data['pageTitle'] = 'Dashboard | OpenSMS';
        $this->renderTemplate('body');
    }
} 