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
        $this->data['user'] = $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        $this->data['pageTitle'] = 'Create Category | '.Core::getSystemSetting(Core::SITE_NAME);
        $this->data['title'] = 'Create Category';

        $category = $this->loadModel('Core_Model_Category');

        if(isset($_POST['category'])){
            $category->Name = $this->getFormData('name');
            $category->ShortDescription = $this->getFormData('shortDescription');
            $category->Description = $this->getFormData('description');
            $category->Keywords = $this->getFormData('keywords');
            $category->SortOrder = $this->getFormData('sortOrder');

            $result = $category->Save();
            if($result === true){
                $this->setNotification('Category added');
                $this->redirectToAction('Index');
            }else{
                $this->setError($result);
            }
        }


        $this->data['category'] = $category;
        $this->data['formAction']= 'add';
        $this->renderTemplate();

    }

    public function Manage($categoryId){
        $category = $this->loadModel('Core_Model_Category', array(0 => $categoryId));
        if(empty($category->Name)){
            $this->setError('Invalid category identity');
            $this->redirectToAction('index');
        }
        if(isset($_POST['name'])){
            $category->Name = $this->getFormData('name');
            $category->ShortDescription = $this->getFormData('shortDescription');
            $category->Description = $this->getFormData('description');
            $category->Keywords = $this->getFormData('keywords');
            $category->SortOrder = $this->getFormData('sortOrder');

            $result = $category->Save();
            if($result === true){
                $this->setNotification('Category updated');
                $this->redirectToAction('Index');
            }else{
                $this->setError($result);
            }
        }
        $this->data['category'] = $category;
        $this->data['formAction']= 'manage';
        $this->renderTemplate();

    }
}