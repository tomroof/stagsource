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

    const USER_CONFIRM = 1;
    const ERROR_NOT_VERIFY = 101;

    public function __construct($email, $password, $user_id = '')
    {
        $this->email = $email;
        $this->password = $password;
        $this->_id = $user_id;
    }

    public function authenticate()
    {

        if (empty($this->_id)) {
            $record = User::model()->findByAttributes(array('email' => $this->email));
            if ($record === null) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else if (!$record->validatePassword($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } elseif ($record->status != self::USER_CONFIRM) {
                $this->errorCode = self::ERROR_NOT_VERIFY;
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

}
