<?php

class ResizeImage {
    
    public static function resizeImg($src, $width, $height, $options = array()) {
        $add_options = '';
        if (isset($options) && count($options) > 0) {
            foreach ($options as $key => $option) {
                $add_options .= '&' . $key . '=' . $option;
            }
        }
        $resize_src = Yii::app()->request->hostInfo . '/vendors/resize.php?src=' . $src . '&h=' . $height . '&w=' . $width . $add_options;

        return $resize_src;
    }
    
}
