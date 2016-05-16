<?php
class Core_Abstract_Module_Base extends Core_Helper_Db{
    public function __construct(){
        if(!isset($_SESSION)){
            session_start();
        }
        $this->module = Core::getCurrentModule();
        $this->data['currentTheme'] = Core::getCurrentTheme();
        $this->date['pageKeyword'] = '';
        $this->data['pageDescription'] = '';

    }

    protected $module = NULL;
    protected $data = array();

    protected function loadHelper($name){
        throw new ErrorException();
    }

    public function loadModel($model_name, array $param = null)
    {
        return Core::loadModel($model_name, $param);
    }

    public function callModelStaticMethod($model, $method, array $param = null){
        return Core::callModelStaticMethod($model, $method, $param);
    }
}
