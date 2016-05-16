<?php
/**
 * Created by Ademu Anthony.
 * User: Tony
 * Date: 3/20/2015
 * Time: 10:09 AM
 */

class Install extends Core_Abstract_Module_Controller {
    public function index(){
        //if installed goto dashboard
        if( $this->getSystemSetting(Core::INSTALLATION_STATUS) == 'installed')
            Core::redirectToAction('index', 'dashboard');

        $this->data['pageTitle'] = 'Install | OpenSMS';
        $_POST['site_url'] = empty($_POST['site_url'])?Core::getBaseUrl():$_POST['site_url'];
        $this->renderTemplate();
    }

    public function save(){
        if(!isset($_POST[Core::DB_HOST])) Core::redirectToAction('index');
        //if installed goto dashboard
        if($this->getSystemSetting(Core::INSTALLATION_STATUS))
            Core::redirectToAction('index', 'dashboard');
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

        $config->{Core::CURRENT_THEME_KEY} = 'default';

        $config->{Core::OPEN_PRICE_PER_UNIT} = $this->getFormData(Core::OPEN_PRICE_PER_UNIT);
        $config->{Core::OPEN_UNITS_PER_SMS} = $this->getFormData(Core::OPEN_UNITS_PER_SMS);

        $config->{Core::INSTALLATION_STATUS} = 'installed';

        //unlink(OpenSms::SETTINGS_FILE_PATH);
        $config->saveXML(Core::SETTINGS_FILE_PATH);


        $this->loadSystemSettings();
        //create tables
        Core_Helper_Db::executeNonQuery($this->getDbScript());

        //create admin account
        $user = $this->loadModel('OpenSms_Model_User');
        $user->LoginId = $this->getFormData('admin_username');
        $user->Password = $this->getFormData('admin_password');
        $user->Role = Core_Model_User::ADMIN;
        $user->Status = 'active';

        $saved = $user->save();


        Core::redirectToAction('complete', 'install', 'admin', [0=>$saved == true?1:0]);
    }

    private function getDbScript(){
        $sql = "CREATE TABLE IF NOT EXISTS `". $this->getTableName('bulksms')."` (
          `id` int(11) NOT NULL,
          `loginId` varchar(50) NOT NULL,
          `sender` varchar(18) NOT NULL,
          `message` text NOT NULL,
          `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `status` int(11) NOT NULL,
          `count` int(11) NOT NULL
        ) ENGINE=InnoDB AUTO_INCREMENT=346 DEFAULT CHARSET=utf8;


        CREATE TABLE IF NOT EXISTS `". $this->getTableName('cards')."` (
          `id` int(11) NOT NULL,
          `serialNumber` varchar(5) NOT NULL,
          `pin` varchar(128) NOT NULL,
          `unit` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



        CREATE TABLE `". $this->getTableName('plans')."` (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `name` VARCHAR(265) NOT NULL ,
            `shortDescription` VARCHAR(500) NOT NULL ,
            `description` VARCHAR(1000) NOT NULL ,
            `keywords` VARCHAR(500) NOT NULL ,
            `price` DOUBLE NOT NULL , PRIMARY KEY (`id`)
        ) ENGINE = InnoDB;

        CREATE TABLE `". $this->getTableName('categories')."` (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `name` VARCHAR(265) NOT NULL ,
            `shortDescription` VARCHAR(500) NOT NULL ,
            `description` VARCHAR(1000) NOT NULL ,
            `image` VARCHAR(265) NOT NULL ,
            `keywords` VARCHAR(265) NOT NULL ,
            `fileName` VARCHAR(265) NOT NULL,
            `sortOrder` INT NOT NULL , PRIMARY KEY (`id`)
        ) ENGINE = InnoDB;

        CREATE TABLE `". $this->getTableName('packagePlanMappings')."` (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `planId` INT NOT NULL ,
            `packageId` INT NOT NULL ,
            PRIMARY KEY (`id`)
        ) ENGINE = InnoDB;

        CREATE TABLE `". $this->getTableName('userPlanMappings')."` (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `planId` INT NOT NULL ,
            `loginId` VARCHAR(265) NOT NULL ,
            PRIMARY KEY (`id`)
        ) ENGINE = InnoDB;


        CREATE TABLE `". $this->getTableName('packages')."` (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `title` VARCHAR(265) NOT NULL ,
            `shortDescription` VARCHAR(500) NOT NULL ,
            `description` VARCHAR(1000) NOT NULL ,
            `categoryId` INT NOT NULL ,
            `keywords` VARCHAR(265) NOT NULL ,
            `image` VARCHAR(265) NOT NULL ,
            `sortOrder` INT NOT NULL ,
            PRIMARY KEY (`id`)
        ) ENGINE = InnoDB;







        CREATE TABLE IF NOT EXISTS `". $this->getTableName('contact')."` (
          `id` int(11) NOT NULL,
          `groupId` int(11) NOT NULL,
          `number` varchar(18) NOT NULL,
          `name` varchar(128) NOT NULL
        ) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8;


        CREATE TABLE IF NOT EXISTS `". $this->getTableName('content')."` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `key` varchar(265) NOT NULL,
          `type` varchar(128) NOT NULL,
          `host` varchar(128) NOT NULL,
          `body` text NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


        CREATE TABLE IF NOT EXISTS `". $this->getTableName('draft')."` (
          `id` int(11) NOT NULL,
          `loginId` varchar(128) NOT NULL,
          `recepient` text NOT NULL,
          `message` varchar(1500) NOT NULL,
          `sender` varchar(18) NOT NULL,
          `deliveryType` varchar(18) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


        CREATE TABLE IF NOT EXISTS `". $this->getTableName('group')."` (
          `id` int(11) NOT NULL,
          `loginId` varchar(128) NOT NULL,
          `name` varchar(128) NOT NULL,
          `description` text NOT NULL
        ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


        CREATE TABLE IF NOT EXISTS `". $this->getTableName('logins')."` (
          `id` int(11) NOT NULL,
          `loginId` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
          `token` varchar(265) COLLATE utf8_unicode_ci NOT NULL,
          `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        CREATE TABLE IF NOT EXISTS `". $this->getTableName('page')."` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `permalink` varchar(50) NOT NULL,
          `title` varchar(265) NOT NULL,
          `layout` varchar(50) NOT NULL,
          `role` varchar(50) NOT NULL,
          `description` text NOT NULL,
          `body` text NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        CREATE TABLE IF NOT EXISTS `". $this->getTableName('passwordresettoken')."` (
          `id` int(11) NOT NULL,
          `token` varchar(265) NOT NULL,
          `emailId` varchar(128) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


        CREATE TABLE IF NOT EXISTS `". $this->getTableName('sms')."` (
          `id` int(11) NOT NULL,
          `bulkSMSId` int(11) NOT NULL,
          `number` varchar(18) NOT NULL,
          `message` text NOT NULL,
          `sender` varchar(18) NOT NULL,
          `status` int(11) NOT NULL,
          `refId` varchar(50) NOT NULL
        ) ENGINE=InnoDB AUTO_INCREMENT=26664 DEFAULT CHARSET=utf8;


        CREATE TABLE IF NOT EXISTS `". $this->getTableName('transactions')."` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `amount` double NOT NULL,
          `unit` INT NOT NULL,
          `status` varchar(64) NOT NULL,
          `description` varchar(265) NOT NULL,
          `paymentMethod` varchar(24) NOT NULL,
          `type` VARCHAR(16) NOT NULL,
          `committed` TINYINT NOT NULL DEFAULT '0',
          `loginId` varchar(128) NOT NULL,
          `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


        CREATE TABLE IF NOT EXISTS `". $this->getTableName('usedcards')."` (
          `id` int(11) NOT NULL,
          `cardId` int(11) NOT NULL,
          `loginId` varchar(28) NOT NULL,
          `dateUsed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


        CREATE TABLE IF NOT EXISTS `". $this->getTableName('users')."` (
          `loginId` varchar(128) NOT NULL,
          `password` varchar(265) NOT NULL,
          `name` varchar(128) NOT NULL,
          `address` varchar(128) NOT NULL,
          `mobileNo` varchar(18) NOT NULL,
          `emailId` varchar(128) NOT NULL,
          `balance` double NOT NULL,
          `status` varchar(16) NOT NULL DEFAULT 'active',
          `role` varchar(16) NOT NULL DEFAULT 'user',
          `dateRegistered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `billing_address1` VARCHAR(250) NOT NULL,
          `billing_address2` VARCHAR(250) NOT NULL,
          `billing_city` VARCHAR(65) NOT NULL,
          `billing_state` VARCHAR(18) NOT NULL,
          `billing_country` VARCHAR(100) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        ALTER TABLE `". $this->getTableName('admins')."`
          ADD PRIMARY KEY (`userName`);


        ALTER TABLE `". $this->getTableName('bulksms')."`
          ADD PRIMARY KEY (`id`);


        ALTER TABLE `". $this->getTableName('cards')."`
          ADD PRIMARY KEY (`id`);


        ALTER TABLE `". $this->getTableName('contact')."`
          ADD PRIMARY KEY (`id`);


        ALTER TABLE `". $this->getTableName('content')."`
          ADD PRIMARY KEY (`id`);


        ALTER TABLE `". $this->getTableName('draft')."`
          ADD PRIMARY KEY (`id`);


        ALTER TABLE `". $this->getTableName('group')."`
          ADD PRIMARY KEY (`id`);

        ALTER TABLE `". $this->getTableName('logins')."`
          ADD PRIMARY KEY (`id`);

        ALTER TABLE `". $this->getTableName('passwordresettoken')."`
          ADD PRIMARY KEY (`id`);

        ALTER TABLE `". $this->getTableName('page')."`
          ADD PRIMARY KEY (`id`);

        ALTER TABLE `". $this->getTableName('sms')."`
          ADD PRIMARY KEY (`id`);

        ALTER TABLE `". $this->getTableName('usedcards')."`
          ADD PRIMARY KEY (`id`);

        ALTER TABLE `". $this->getTableName('users')."`
          ADD PRIMARY KEY (`loginId`);

        ALTER TABLE `". $this->getTableName('bulksms')."`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=346;

        ALTER TABLE `". $this->getTableName('cards')."`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

        ALTER TABLE `". $this->getTableName('contact')."`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=187;

        ALTER TABLE `". $this->getTableName('content')."`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=147;

        ALTER TABLE `". $this->getTableName('group')."`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;

        ALTER TABLE `". $this->getTableName('logins')."`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;

        ALTER TABLE `". $this->getTableName('page')."`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

        ALTER TABLE `". $this->getTableName('sms')."`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26664;

        ALTER TABLE `". $this->getTableName('usedcards')."`
          MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

        ";

        return $sql;
    }

    public function complete($success){
        $this->data['pageTitle'] = 'Install -> Complete | OpenSms';
        $this->data['success'] = $success;
        $this->data['message'] = $success?'Installation of OpenSMS has been successfully carried out':'Error in installing OpenSMS';
        if($success) $this->setNotification($this->data['message'], 'complete_install');
        else $this->setError($this->data['message'], 'complete_install');
        $this->renderTemplate('body');
    }
}