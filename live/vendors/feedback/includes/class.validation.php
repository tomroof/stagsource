<?php

class validation{

    static function isEmpty($data){
        if($data == ''){
            return true;
        }
        return false;
    }

    static function notEmpty($data){
        if($data != ''){
            return true;
        }
        return false;
    }

    static function isEmail($data){
        if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$data)){
            return true;
        }
        return false;
    }

}

?>
