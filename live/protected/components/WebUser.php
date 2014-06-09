<?php

class WebUser extends CWebUser
{


    private $model;

    public function isAdmin()
    {

        $user = $this->loadUser(Yii::app()->user->id);
        if ($user == NULL) {
            return FALSE;
        }
        return intval($user->role_id) == User::ADMIN_ROLE;
    }

    public function isWebUser()
    {

        $user = $this->loadUser(Yii::app()->user->id);
        if ($user == NULL) {
            return FALSE;
        }
        return intval($user->role_id) == User::WEBUSER_ROLE;
    }

    // Load user model.
    protected function loadUser($id = NULL)
    {
        if ($this->model === NULL) {
            if ($id !== NULL) {
                $this->model = User::model()->findByPk($id);
            }
        }
        return $this->model;
    }

 public function getUsername()
    {
        $username = User::model()->findByPk($this->id);
        if ($username) {
            return $username->first_name . ' ' . substr($username->last_name, 0, 1) . '.';
        }
    }
    
 public function getModel()
    {
        if(!isset($this->id)) $this->model = new User;
        if($this->model === null)
            $this->model = User::model()->findByPk($this->id);
        return $this->model;
    }
 
    public function __get($name) {
        try {
            return parent::__get($name);
        } catch (CException $e) {
            $m = $this->getModel();
            if($m->__isset($name))
                return $m->{$name};
            else throw $e;
        }
    }
 
    public function __set($name, $value) {
        try {
            return parent::__set($name, $value);
        } catch (CException $e) {
            $m = $this->getModel();
            $m->{$name} = $value;
        }
    }
 
    public function __call($name, $parameters) {
        try {
            return parent::__call($name, $parameters);  
        } catch (CException $e) {
            $m = $this->getModel();
            return call_user_func_array(array($m,$name), $parameters);
        }
    }
    
    

}