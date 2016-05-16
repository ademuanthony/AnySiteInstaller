<?php
/**
 * Created by Ademu Anthony.
 * User: Tony
 * Date: 4/4/2015
 * Time: 3:30 PM
 */

class Settings extends Core_Abstract_Module_Controller {
    public function Index(){
        $this->data['user'] = $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        $this->data['pageTitle'] = 'Settings | '.$this->getSystemSetting(Core::SITE_NAME);
        $this->data['settings'] = null;

        $this->renderTemplate();
    }

    public function Save(){
        //if installed goto dashboard
        //if($this->getSystemSetting(OpenSms::INSTALLATION_STATUS))
          //  OpenSms::redirectToAction('index', 'dashboard');
        //var_dump($_POST);die();
        // CREATE
        $config = new SimpleXmlElement('<settings/>');

        $config->{Core::VERSION} = $this->getSystemSetting(Core::VERSION);
        $config->{Core::SITE_NAME} = $this->getFormData(Core::SITE_NAME);
        $config->{Core::SITE_HOME_KEYWORD} = $this->getFormData(Core::SITE_HOME_KEYWORD);
        $config->{Core::SITE_HOME_DESCRIPTION} = $this->getFormData(Core::SITE_HOME_DESCRIPTION);
        $config->{Core::SITE_URL} = $this->getFormData(Core::SITE_URL);


        $config->{Core::DB_TYPE} = 'mysql';
        $config->{Core::DB_HOST} = $this->getFormData(Core::DB_HOST);
        $config->{Core::DB_NAME} = $this->getFormData(Core::DB_NAME);
        $config->{Core::DB_TABLE_PREFIX} = $this->getFormData(Core::DB_TABLE_PREFIX);
        $config->{Core::DB_USERNAME} = $this->getFormData(Core::DB_USERNAME);
        $config->{Core::DB_PASSWORD} = $this->getFormData(Core::DB_PASSWORD);
        $config->{Core::DB_PASSWORD} = $this->getFormData(Core::DB_PASSWORD);

        $config->{Core::CURRENT_THEME_KEY} = $this->getFormData(Core::CURRENT_THEME_KEY);

        $config->{Core::OPEN_PRICE_PER_UNIT} = $this->getFormData(Core::OPEN_PRICE_PER_UNIT);
        $config->{Core::OPEN_UNITS_PER_SMS} = $this->getFormData(Core::OPEN_UNITS_PER_SMS);

        $config->{Core::INSTALLATION_STATUS} = 'installed';
        //unlink(OpenSms::SETTINGS_FILE_PATH);
        $config->saveXML(Core::SETTINGS_FILE_PATH);

        $this->setNotification('Settings saved', 'settings_save');
        Core::redirectToAction('index');
    }
} 