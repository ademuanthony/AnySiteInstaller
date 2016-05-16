<?php

/**
 * Created by PhpStorm.
 * User: ELACHI
 * Date: 5/15/2016
 * Time: 10:15 PM
 */

class Categories extends Core_Abstract_Module_Controller
{
    public function Index(){
        $this->data['user'] = $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        $this->data['pageTitle'] = 'Manage Categories | '.Core::getSystemSetting(Core::SITE_NAME);

        $this->data['categories'] = Core::callModelStaticMethod('Core_Model_Category', 'GetCategories');
        $this->renderTemplate();
    }

    public function Add(){
        $plan = $this->loadModel('Core_Model_Category');
        $plan->Name = $this->getFormData('name');
        $plan->ShortDescription = $this->getFormData('shortDescription');
        $plan->Description = $this->getFormData('description');
        $plan->Keywords = $this->getFormData('keywords');
        $plan->SortOrder = $this->getFormData('sortOrder');

        $result = $plan->Save();
        if($result === true){
            $this->setNotification('Category added');
        }else{
            $this->setError($result);
        }
        $this->redirectToAction('Index');
    }

    public function Update(){
        $plan = $this->loadModel('Core_Model_Category', array(0 => $this->getFormData('categoryId')));
        if(empty($plan->Name)){
            $this->setError('Invalid category identity');
            $this->redirectToAction('index');
        }
        $plan->Name = $this->getFormData('name');
        $plan->ShortDescription = $this->getFormData('shortDescription');
        $plan->Description = $this->getFormData('description');
        $plan->Keywords = $this->getFormData('keywords');
        $plan->SortOrder = $this->getFormData('sortOrder');

        $result = $plan->Save();
        if($result === true){
            $this->setNotification('Category updated');
        }else{
            $this->setError($result);
        }
        $this->redirectToAction('Index');
    }
}