<?php
/**
 * Provides basic email sending functionality using PHP's mail() function
 * @see class.config.php
 */
class basicMailer {

    /**
     * Function specific to feedback to generate email body content from array of posted vars
     * @param array $data
     * @return string
     */
    public function bodyGenerator($data) {
        $output = config::$mailGreeting;
        $output = str_replace('@feedback@', $data['feedbackType'], $output);
        foreach($data['details'] as $key => $item) {
            if ($item == '') {
                $item = '[not entered]';
            }
            $output .= $key . ': "' . $item . '"' . "\n";
        }
        return $output;
    }

    /**
     * Generic mailer function, depends on values in class.config.php if not specified
     * @param string $mailBody
     * @param string $mailTo
     * @param string $mailFrom
     * @param string $mailSubject
     * @return boolean
     */
    public function sendMail($mailBody, $mailTo = '', $mailFrom = '', $mailSubject = '') {
        //check for passed params
        if ($mailTo == '') {
            $mailTo = config::$mailTo;
        }
        if ($mailFrom == '') {
            $mailFrom = config::$mailFrom;
        }
        if ($mailSubject == '') {
            $mailSubject = config::$mailSubject;
        }

        $mail = mail($mailTo, $mailSubject, $mailBody, 'From: ' . $mailFrom);

        if ($mail) {
            return true;
        }
        return false;
    }

    /**
     * Because not everyone has a mail server installed on their dev machine...
     */
    public function sendVirtualMail($mailBody, $mailTo = '', $mailFrom = '', $mailSubject = '') {
        //check for passed params
        if ($mailTo == '') {
            $mailTo = config::$mailTo;
        }
        if ($mailFrom == '') {
            $mailFrom = config::$mailFrom;
        }
        if ($mailSubject == '') {
            $mailSubject = config::$mailSubject;
        }

        var_dump($mailTo);
        var_dump($mailSubject);
        var_dump($mailBody);
        var_dump($mailFrom);

    }
}
?>
