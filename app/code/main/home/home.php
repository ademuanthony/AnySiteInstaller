<?php
class Home extends Core_Abstract_Module_Controller{
    public function Index(){
        $user = $this->checkLogin();
        //take him to his dashboard based on his role
        $this->redirectToAction('index', 'dashboard', 'dashboard');

        $this->data['pageTitle'] = Core::getSystemSetting(Core::SITE_NAME);
        $this->data['pageKeyword'] = Core::getSystemSetting(Core::SITE_HOME_KEYWORD);
        $this->data['pageDescription'] = Core::getSystemSetting(Core::SITE_HOME_DESCRIPTION);
        $this->renderTemplate();
    }

}
