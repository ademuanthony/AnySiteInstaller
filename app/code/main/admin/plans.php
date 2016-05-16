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
        $this->data['sn'] = 0;
        $this->renderTemplate();
    }

    public function Add(){
        $this->data['user'] = $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        $this->data['pageTitle'] = 'Create Plan | '.Core::getSystemSetting(Core::SITE_NAME);
        $this->data['title'] = 'Create Plan';

        $plan = $this->loadModel('Core_Model_Plan');

        if(isset($_POST['name'])){
            $plan->Name = $this->getFormData('name');
            $plan->ShortDescription = $this->getFormData('shortDescription');
            $plan->Description = $this->getFormData('description');
            $plan->Keywords = $this->getFormData('keywords');
            $plan->Price = $this->getFormData('price');

            $result = $plan->Save();
            if($result === true){
                $this->setNotification('Plan added');
                $this->redirectToAction('Index');
            }else{
                $this->setError($result);
            }
        }
        $this->data['plan'] = $plan;
        $this->data['formAction']= 'add';
        $this->renderTemplate();
    }

    public function Manage($planId){
        $this->data['user'] = $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        $this->data['pageTitle'] = 'Create Plan | '.Core::getSystemSetting(Core::SITE_NAME);
        $this->data['title'] = 'Manage Plan';

        $plan = $this->loadModel('Core_Model_Plan', array(0 => $planId));
        if(empty($plan->Name)){
            $this->setError('Invalid plan identity');
            $this->redirectToAction('index');
        }

        if(isset($_POST['name'])){
            $plan->Name = $this->getFormData('name');
            $plan->ShortDescription = $this->getFormData('shortDescription');
            $plan->Description = $this->getFormData('description');
            $plan->Keywords = $this->getFormData('keywords');
            $plan->Price = $this->getFormData('price');

            $result = $plan->Save();
            if($result === true){
                $this->setNotification('Plan updated');
                $this->redirectToAction('Index');
            }else{
                $this->setError($result);
            }
        }

        $this->data['plan'] = $plan;
        $this->data['formAction']= 'manage';
        $this->renderTemplate();

    }
}