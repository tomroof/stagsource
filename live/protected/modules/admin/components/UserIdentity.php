<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    private $_id;
    public $email;

    public function __construct($email, $password, $user_id = '')
    {
        $this->email = $email;
        $this->password = $password;
        $this->_id = $user_id;
    }

    public function authenticate()
    {

        if (empty($this->_id)) {
            $record = User::model()->findByAttributes(array('email' => $this->email, 'role_id' => 1));
            if ($record === null) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else if (!$this->validatePassword($record->passwd)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->_id = $record->id;
                //   $this->setState('title', $record->title);
                $this->errorCode = self::ERROR_NONE;
            }
        } else {

            $record = User::model()->findByAttributes(array('id' => $this->_id));
            if ($record === null) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else {
                $this->_id = $record->id;
                $this->errorCode = self::ERROR_NONE;
            }
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

    public $salt;

    public function validatePassword($password)
    {
        return $this->hashPassword($this->password, $this->salt) === $password;
    }

    public function hashPassword($password, $salt)
    {
        return md5($salt . $password);
    }

}
