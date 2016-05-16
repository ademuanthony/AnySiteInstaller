<?php
/**
 * Created by PhpStorm.
 * User: Tony
 * Date: 6/29/2015
 * Time: 4:39 PM
 */

class Actions extends Core_Abstract_Module_Controller{
    public static function TriggerEditor(){
        if(isset($_GET['action']) && $_GET['action'] == 'cms'){
            Core::checkLogin(Core::OPEN_ROLE_ADMIN);
            Core::registerView('cms_ck_editor_js', 'default/assets/plugins/ckeditor/ckeditor.js', Core::VIEW_TYPE_SCRIPT, Core::VIEW_POSITION_TOP);
            Core::registerView('cms_content_editor', 'default/template/cms/content_editor.php', Core::VIEW_TYPE_HTML, Core::VIEW_POSITION_FOOTER);
            Core::registerView('cms_editor_js', 'default/assets/js/cms.js', Core::VIEW_TYPE_SCRIPT, Core::VIEW_POSITION_FOOTER);
            Core::registerView('cms_editor_css', 'default/assets/css/cms.css', Core::VIEW_TYPE_STYLE, Core::VIEW_POSITION_TOP);
        }
    }

    public static function TriggerDisplayPage(array $param){
        //var_dump($param); die();
        $action = new Actions();
        if($action->DisplayPage($param[0])) exit;
    }

    private $page = null;
    public function DisplayPage($key){
        $this->page = $this->loadModel('OpenSms_Model_Page', [0 => $key]);

        if(!isset($this->page->Id)) return false;

        $this->module = Core_Model_System_Module::getModule('cms');
        Core::setCurrentModule($this->module);
        Core::setCurrentRoute(new Core_Model_System_Route($key, 'Actions', 'main/cms/actions.php', 'DisplayPage'));


        $this->data['contentKey'] = 'opensms_page_'.$this->page->Permalink;
        $this->data['page'] = $this->page;
        $this->data['pageTitle'] = $this->page->Title;
        $this->renderTemplate();
        return true;
    }

    protected function getLayoutFileKey(){
        return $this->page->Layout;
    }
} 