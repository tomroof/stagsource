<?php

/**
 * Challenges users with a basic captcha test to check that they are human.
 * @todo Currently basic moving challenge to an animated GIF will help prevent bots (or: recaptcha)
 */
class basicCaptcha{

    /**
     * Private variable to hold captcha answer
     * @var private integer
     */
    private $_answer;
    /**
     * first number
     * @var integer
     */
    private $_number1;
    /**
     * second number
     * @var integer
     */
    private $_number2;
    /**
     * Holds a string representation of the mathmatical operation to be performed
     * @var string
     */
    private $_operation;
    

    /**
     * Generates 2 random numbers between 0 and 9 and performs addition, subtraction or
     * multiplication to be used for a basic captcha
     */
    public function  generate() {

        $number1 = rand(0, 9);
        $number2 = rand(0, 9);

        $rand = rand(0,2); //random var to decide mathmatical operation

        if ($rand == '0'){
            $this->_answer = $number1 + $number2;
            $this->_number1 = $number1;
            $this->_number2 = $number2;
            $this->_operation = ' plus (+) ';
        } elseif ($rand == '1'){
            $this->_answer = $number1 - $number2;
            $this->_number1 = $number1;
            $this->_number2 = $number2;
            $this->_operation = ' minus (-) ';
        } elseif ($rand == '2'){
            $this->_answer = $number1 * $number2;
            $this->_number1 = $number1;
            $this->_number2 = $number2;
            $this->_operation = ' times (*) ';
        }

        $_SESSION['captchaAnswer'] = $this->_answer;

    }

    /**
     * Returns the captcha challenge text.
     * @param string $displayMethod Pass nothing for basic text only return or 'html' for marked up return for styling via CSS
     * @return string
     */
    public function display($displayMethod = ''){
        if ($displayMethod == ''){
            return $this->_number1 . $this->_operation . $this->_number2;
        } elseif($displayMethod == 'html'){
            $prependNumber1 = '<span class="number">';
            $appendNumber1 = '</span>';
            $prependOperation = '<span class="operation">';
            $appendOperation = '</span>';
            $prependNumber2 = '<span class="number">';
            $appendNumber2 = '</span>';
            
            return $prependNumber1 . $this->_number1 . $appendNumber1 . $prependOperation . $this->_operation .  $appendOperation . $prependNumber2 . $this->_number2 . $appendNumber2;
        }
        
    }

    /**
     * Pass the user answer and this returns whether captcha is passed or not
     * @param integer $userAnswer
     * @return boolean
     */
    public function validate($userAnswer){
        if (isset($_SESSION['captchaAnswer'])){
            if ($userAnswer == $_SESSION['captchaAnswer']){
                unset($_SESSION['captchaAnswer']);
                return true;
            }
        }
        return false;
    }


}

?>
