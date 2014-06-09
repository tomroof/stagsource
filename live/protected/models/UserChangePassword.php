<?php
/**
 * UserChangePassword class.
 * @package application.modules.user.models
 */
class UserChangePassword extends CFormModel {

    public $passwd;
    public $oldPassword;

    /**
     *
     * @var User
     */
    public $user;

    public function rules() {
        return array(
            array('passwd, oldPassword', 'required'),
            array('oldPassword', 'checkPassword'),
            array('passwd', 'length', 'min' => 4, 'message' => "Incorrect password (minimal length 4 symbols)."),
        );
    }

    public function checkPassword($attribute, $params) {
        if (!$this->hasErrors()) {
            if(!$this->user||!$this->user->checkPassword($this->oldPassword)) {
                $this->addError("oldPassword",  "Existing password is incorrect.");
            }
        }
    }


    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'oldPassword' =>  "Existing Password:",
            'passwd' => "New Password:",
        );
    }

}

