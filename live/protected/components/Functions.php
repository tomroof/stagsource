<?php

class Functions {

    public static function listYears() {
        /*         * ************************************************
         * Genereted list  of years  from min to max.
         * ************************************************ */
        $currentYear = date('Y');

        $startYear = 1901;
        $result = array();
        for ($i = $currentYear; $currentYear >= $startYear; $currentYear--) {
            $result[$currentYear] = $currentYear;
        }
        return $result;
    }

    public static function dump($var, $depth = 10, $highlight = true) {
        /*         * ************************************************
         * Standart var dump function with highlight
         * ************************************************ */
        echo CVarDumper::dumpAsString($var, $depth, $highlight);
    }

    public static function encrypt($string) {
        /*         * ************************************************
         * Set encrypt method for all project
         * ************************************************ */
        return md5($string);
    }

    public static function getTimeUSA($date) {
        $time = date('m/d/Y H:i:s', strtotime($date));
        return $time;
    }
    public static function getDateUSA($date) {
        $time = date('m.d.Y', strtotime($date));
        return $time;
    }

    public static function passgen() {
        $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        $max = 6;
        $size = StrLen($chars) - 1;
        $password = null;
        while ($max--)
            $password.=$chars[rand(0, $size)];

        return $password;
    }

    public static function generationPermalink($permalink, $find_like_permalink) {
        if (empty($find_like_permalink)) {
            $result = $permalink;
        } else {
            foreach ($find_like_permalink as $value) {               
                $found = preg_replace('/' . preg_quote($permalink) . '\-.*/isU', '', $value);
            }
            if ($permalink != $found)
                $result = $permalink . '-' . ((int) $found + 1);
            else
                $result = $permalink . '-1';
        }
        return $result;
    }

    public static function getPrewText($string, $length = 28)
    {
        $str = strip_tags($string);
        if (strlen($string) > $length && strlen($string)!=0) {
            $str = substr($str, 0, $length);
            $pos = strrpos($str, ' ');
            return substr($str, 0, $pos) . '...';
        } else {
            return $string;
        }
    }

    public static function renderEmailNotif($f_name, $model_u, $passwd)
    {
        return Yii::app()->controller->renderFile(Yii::getPathOfAlias('webroot') . '/protected/views/email_template/' . $f_name . '.php', array('model_u' => $model_u, 'passwd' => $passwd), true);
    }

}

