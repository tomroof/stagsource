<?php
 
class WebUser extends CWebUser {
 
    private $_model;
 
    public function isAdmin()
    {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user == NULL) {
            return FALSE;
        }
        return intval($user->role_id) == User::ADMIN_ROLE;
    }


    // Load user model.
    protected function loadUser($id = NULL) {
        if ($this->_model === NULL) {
            if ($id !== NULL) {
                $this->_model = User::model()->findByPk($id);
            }
               
        }
        return $this->_model;
    }

    public function getUsername()
    {
    	$username=User::model()->findByPk($this->id);
    	if($username) {
    		return $username->email;
    	}
    	//return $username;
    }    
}