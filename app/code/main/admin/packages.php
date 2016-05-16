<?php

/**
 * Created by PhpStorm.
 * User: ELACHI
 * Date: 5/15/2016
 * Time: 10:33 PM
 */
class Packages extends Core_Abstract_Module_Controller
{
    public function Index(){
        $this->data['user'] = $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        $this->data['pageTitle'] = 'Manage Packages | '.Core::getSystemSetting(Core::SITE_NAME);

        $this->data['packages'] = Core::callModelStaticMethod('Core_Model_Package', 'GetCategories');
        $this->renderTemplate();
    }

    public function Add(){
        $package = $this->loadModel('Core_Model_Package');
        $package->Title = $this->getFormData('title');
        $package->ShortDescription = $this->getFormData('shortDescription');
        $package->Description = $this->getFormData('description');
        $package->Keywords = $this->getFormData('keywords');
        $package->SortOrder = $this->getFormData('sortOrder');
        $package->CategoryId = $this->getFormData('categoryId');

        //image
        $uploadResult = $this->uploadImage('image', 'app/skin/assets/images/uploads', str_replace(' ', '_', $package->Title));
        if($uploadResult['success']){
            $package->Image = $uploadResult['newName'];
        }else{
            $this->setError($uploadResult['errorMessage']);
            $this->redirectToAction('index');
        }

        $result = $this->CreatePackageFromUpload($package->Title);
        if($result !== true){
            $this->setError($result);
            $this->redirectToAction('index');
        }

        $result = $package->Save();
        if($result === true){
            $this->setNotification('Package added');
        }else{
            $this->setError($result);
        }
        $this->redirectToAction('Index');
    }

    public function Update(){
        $plan = $this->loadModel('Core_Model_Package', array(0 => $this->getFormData('categoryId')));
        if(empty($plan->Name)){
            $this->setError('Invalid package identity');
            $this->redirectToAction('index');
        }
        $plan->Title = $this->getFormData('title');
        $plan->ShortDescription = $this->getFormData('shortDescription');
        $plan->Description = $this->getFormData('description');
        $plan->Keywords = $this->getFormData('keywords');
        $plan->SortOrder = $this->getFormData('sortOrder');
        $plan->Images = $this->getFormData('images');
        $plan->CategoryId = $this->getFormData('categoryId');

        $result = $plan->Save();
        if($result === true){
            $this->setNotification('Packge updated');
        }else{
            $this->setError($result);
        }
        $this->redirectToAction('Index');
    }

    public function Delete($id){
        $this->checkLogin(Core::OPEN_ROLE_ADMIN);
        $this->loadModel('Core_Model_Package', array(0 => $id))->Delete();
        $this->setNotification('Deleted');
        $this->redirectToAction('index');
    }

    private function CreatePackageFromUpload($title){
        $packageName = str_replace(' ', '_', $title);
        if($_FILES["zip_file"]["name"]) {
            $filename = $_FILES["zip_file"]["name"];
            $source = $_FILES["zip_file"]["tmp_name"];
            $type = $_FILES["zip_file"]["type"];

            $name = explode(".", $filename);
            $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
            foreach($accepted_types as $mime_type) {
                if($mime_type == $type) {
                    $okay = true;
                    break;
                }
            }

            $continue = strtolower($name[1]) == 'zip' ? true : false;
            if(!$continue) {
                $message = "The file you are trying to upload is not a .zip file. Please try again.";
                return $message;
            }


            $packageRoot = Core::getDocumentRoot().'app/skin/packages/';
            $target_path = $packageRoot.$packageName;

            //copy the empty package
            $this->copyDirectory(Core::getDocumentRoot().'app/skin/packages/empty', $target_path);


            if(move_uploaded_file($source, $target_path.'/content')) {
                $zip = new ZipArchive();
                $x = $zip->open($target_path);
                if ($x === true) {
                    $zip->extractTo($target_path.'/content');
                    $zip->close();

                    unlink($target_path);
                    //zip the installer
                    $this->zipData($target_path, "$target_path.zip");
                    //delete the temp folder
                    unlink($target_path);
                    rmdir($target_path);
                    return true;

                }
            } else {
                return "There was a problem with the upload. Please try again.";
            }

        }
    }

}