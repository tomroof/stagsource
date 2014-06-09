<?php
require_once('includes/config.php');

/* URL PARAMETERS
 * action = feedback type
 * r = referring URL 
 */
$action = $_GET['action'];
$referral = urldecode($_GET['r']);


?>


<?php

echo util::loadTemplate('includes/templates/htmlHeader.php');

//generate title and load header
if ($action == 'comment'){
    $title = 'Feedback >> Comment';
} elseif ($action == 'suggestion'){
    $title = 'Feedback >> Suggestion';
} elseif ($action == 'bug'){
    $title = 'Feedback >> Bug Report';
} else {
    $title = 'Feedback';
}
echo util::loadTemplate('includes/templates/header.php',array('title' => $title));

//if the feedback form is submitted, perform data validation and do something with the feedback
if(isset($_POST['submit']) || isset($_POST['feedback'])){
    $feedbackType = $_POST['feedback'];
    //if feedback is a suggestion
    if ($feedbackType == 'suggestion'){
        $suggestionText = strip_tags($_POST['suggestionText'],ENT_QUOTES);
        $name = strip_tags($_POST['name'],ENT_QUOTES);
        $email = strip_tags($_POST['email'],ENT_QUOTES);
        $captchaAnswer = strip_tags($_POST['captchaAnswer'], ENT_QUOTES);
        //make sure suggestion has been entered
        if (!isset($suggestionText) || validation::isEmpty($suggestionText)){
            $errors[] = 'You need to enter a suggestion!';
        }
        //if email entered, ensure it is valid
        if (validation::notEmpty($email) && validation::isEmail($email) == false){
            $errors[] = 'You need to enter a valid email address!';
        }
        //captcha validation
        $captcha = new basicCaptcha();
        if ($captcha->validate($captchaAnswer) == false || validation::isEmpty($captchaAnswer)){
            $errors[] = 'The captcha (challenge text) you entered was incorrect.';
        }
        //finished validating - return validation errors
        if (isset($errors)){
            echo util::loadTemplate('includes/templates/validationError.php', array($errors));
            echo util::loadTemplate('includes/templates/suggestion.php');
        } else { //no errors, proceed with execution
            $mailer = new basicMailer();
            $body = $mailer->bodyGenerator(array(
                'feedbackType' => 'suggestion',
                'details' => array(
                    'Suggestion' => $suggestionText,
                    'User Name' => $name,
                    'User Email' => $email,
                    'User Agent' => $_SERVER['HTTP_USER_AGENT'],
                    'User IP' => $_SERVER['REMOTE_ADDR'],
                    'Referer' => $_SESSION['referer']
                )
            ));
            $mailer->sendMail($body, '', '', 'New suggestion about your website');
            echo util::loadTemplate('includes/templates/success.php');
        }
    }
    //if feedback is a comment
    if ($feedbackType == 'comment'){
        $commentText = strip_tags($_POST['commentText'],ENT_QUOTES);
        $name = strip_tags($_POST['name'],ENT_QUOTES);
        $email = strip_tags($_POST['email'],ENT_QUOTES);
        $captchaAnswer = strip_tags($_POST['captchaAnswer'], ENT_QUOTES);
        //make sure comment has been entered
        if (!isset($commentText) || validation::isEmpty($commentText)){
            $errors[] = 'You need to enter a comment!';
        }
        //if email entered, ensure it is valid
        if (validation::notEmpty($email) && validation::isEmail($email) == false){
            $errors[] = 'You need to enter a valid email address!';
        }
        //captcha validation
        $captcha = new basicCaptcha();
        if ($captcha->validate($captchaAnswer) == false || validation::isEmpty($captchaAnswer)){
            $errors[] = 'The captcha (challenge text) you entered was incorrect.';
        }
        //finished validating - return validation errors
        if (isset($errors)){
            echo util::loadTemplate('includes/templates/validationError.php', array($errors));
            echo util::loadTemplate('includes/templates/comment.php');
        } else { //no errors, proceed with execution
            $mailer = new basicMailer();
            $body = $mailer->bodyGenerator(array(
                'feedbackType' => 'comment',
                'details' => array(
                    'Comment' => $commentText,
                    'User Name' => $name,
                    'User Email' => $email,
                    'User Agent' => $_SERVER['HTTP_USER_AGENT'],
                    'User IP' => $_SERVER['REMOTE_ADDR'],
                    'Referer' => $_SESSION['referer']
                )
            ));
            $mailer->sendMail($body, '', '', 'New comment on your website');
            echo util::loadTemplate('includes/templates/success.php');
        }
    }
    //if feedback is a bug
    if ($feedbackType == 'bug'){
        $bugCategory = strip_tags($_POST['bugCategory'],ENT_QUOTES);
        $bugSummary = strip_tags($_POST['bugSummary'],ENT_QUOTES);
        $bugDetail = strip_tags($_POST['bugDetail'],ENT_QUOTES);
        $name = strip_tags($_POST['name'],ENT_QUOTES);
        $email = strip_tags($_POST['email'],ENT_QUOTES);
        $captchaAnswer = strip_tags($_POST['captchaAnswer'], ENT_QUOTES);
        //make sure bug summary has been entered
        if (!isset($bugSummary) || validation::isEmpty($bugSummary)){
            $errors[] = 'You need to enter a bug summary!';
        }
        //if email entered, ensure it is valid
        if (validation::notEmpty($email) && validation::isEmail($email) == false){
            $errors[] = 'You need to enter a valid email address!';
        }
        //captcha validation
        $captcha = new basicCaptcha();
        if ($captcha->validate($captchaAnswer) == false || validation::isEmpty($captchaAnswer)){
            $errors[] = 'The captcha (challenge text) you entered was incorrect.';
        }
        //finished validating - return validation errors
        if (isset($errors)){
            echo util::loadTemplate('includes/templates/validationError.php', array($errors));
            echo util::loadTemplate('includes/templates/bug.php');
        } else { //no errors, proceed with execution
            $mailer = new basicMailer();
            $body = $mailer->bodyGenerator(array(
                'feedbackType' => 'bug',
                'details' => array(
                    'Bug Category' => $bugCategory,
                    'Bug Summary' => $bugSummary,
                    'Bug Detail' => $bugDetail,
                    'User Name' => $name,
                    'User Email' => $email,
                    'User Agent' => $_SERVER['HTTP_USER_AGENT'],
                    'User IP' => $_SERVER['REMOTE_ADDR'],
                    'Referer' => $_SESSION['referer']
                )
            ));
            $mailer->sendMail($body, '', '', 'New bug report on your website');
            echo util::loadTemplate('includes/templates/success.php');
        }
    }
} else { 
    //set referring url
    $_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
    //if feedback form has not been submitted then load appropriate template file for feedback type
    if ($action == 'comment'){
        echo util::loadTemplate('includes/templates/comment.php');
    } elseif ($action == 'suggestion'){
        echo util::loadTemplate('includes/templates/suggestion.php');
    } elseif ($action == 'bug'){
        echo util::loadTemplate('includes/templates/bug.php');
    } elseif ($action == '') {
        echo util::loadTemplate('includes/templates/main.php');
    } else{
        echo util::loadTemplate('includes/templates/incorrectAction.php');
    }
}

echo util::loadTemplate('includes/templates/htmlFooter.php');

?>
