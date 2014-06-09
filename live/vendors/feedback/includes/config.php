<?php
/*
 * Config files loads at start of each page. Includes static config class for holding config vars.
 * At the end of this script are the required includes plus a call to start sessions to make the captcha work.
 */


class config{

/**
 * The email address/addresses to send to, separate multiple recipients using ','
 * Overwritable in class.basicMailer.php->sendMail() method.
 * @var string
 */
static $mailTo = 'support@example.com';
/**
 * The email address the recipient will see. Ideally should match domain name to reduce likelihood of spam classification.
 * Overwritable in class.basicMailer.php->sendMail() method.
 * @var string
 */
static $mailFrom = 'Film Crew Builde <info@example.com>';
/**
 * Email subject
 * Overwritable in class.basicMailer.php->sendMail() method.
 * @var string
 */
static $mailSubject = 'New feedback on your website';
/**
 * The greeting text in emails. You can use '@feedback@' to identify the feedback type. This is a reference to the
 * array key 'feedbackType' and gets string replaced if found.
 * @var string
 */
static $mailGreeting = "Hi, some new feedback has been sent from your website. The feedback falls in to the following category: @feedback@. The feedback is as follows: \n\n";


}

//includes
require_once('class.util.php');
require_once('class.basicCaptcha.php');
require_once('class.basicMailer.php');
require_once('class.validation.php');

//start sessions
session_start();



?>