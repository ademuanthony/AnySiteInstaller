<?php

/**
 * Created by PhpStorm.
 * User: ELACHI
 * Date: 5/15/2016
 * Time: 9:46 PM
 */
class Plans extends Core_Abstract_Module_Controller
{
    public function Index(){
        $this->data['user'] = $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        $this->data['pageTitle'] = 'Manage Plans | '.Core::getSystemSetting(Core::SITE_NAME);

        $this->data['plans'] = Core::callModelStaticMethod('Core_Model_Plan', 'GetPlans');
        $this->renderTemplate();
    }

    public function Add(){
        $plan = $this->loadModel('Core_Model_Plan');
        $plan->Name = $this->getFormData('name');
        $plan->ShortDescription = $this->getFormData('shortDescription');
        $plan->Description = $this->getFormData('description');
        $plan->Keywords = $this->getFormData('keywords');
        $plan->Price = $this->getFormData('price');

        $result = $plan->Save();
        if($result === true){
            $this->setNotification('Plan added');
        }else{
            $this->setError($result);
        }
        $this->redirectToAction('Index');
    }

    public function Update(){
        $plan = $this->loadModel('Core_Model_Plan', array(0 => $this->getFormData('planId')));
        if(empty($plan->Name)){
            $this->setError('Invalid plan identity');
            $this->redirectToAction('index');
        }
        $plan->Name = $this->getFormData('name');
        $plan->ShortDescription = $this->getFormData('shortDescription');
        $plan->Description = $this->getFormData('description');
        $plan->Keywords = $this->getFormData('keywords');
        $plan->Price = $this->getFormData('price');

        $result = $plan->Save();
        if($result === true){
            $this->setNotification('Plan updated');
        }else{
            $this->setError($result);
        }
        $this->redirectToAction('Index');
    }
}