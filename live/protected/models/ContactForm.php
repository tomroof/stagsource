<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel {

    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $company;
    public $body;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            // name, email, subject and body are required
            array('first_name, email, last_name, body', 'required'),
            // email has to be a valid email address
            array('email', 'email'),
            array('phone, company,first_name, email, last_name, body', 'safe'),
            // verifyCode needs to be entered correctly
         //   array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
         //   'verifyCode' => 'Verification Code',
            'body' => 'Message'
        );
    }

}