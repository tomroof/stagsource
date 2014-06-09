<?php

class LoginForm extends CFormModel
{
    public $email;

    public function rules()
	{
		return array(
			// username and password are required
			array('email', 'required'),
              array('email', 'email'),
            );
	}
}
?>
