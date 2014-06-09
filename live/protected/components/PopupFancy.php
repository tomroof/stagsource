<?php

class PopupFancy {
    
  


    static function showMessage($content, $params = array()) {
        $out = '';
        $content = trim($content);
        $content = preg_replace('/\\r/', '', $content);
        $content = preg_replace('/\\n/', '', $content);
        $content = str_replace('"','\"',$content);
        $out =  '"content": "'.$content.'"';
   
       
       foreach ($params as $k => $v) {
           $out .= ', "' . $k . '":' . $v;
       }
 
        $script = "$.fancybox({ $out })";
        
        Yii::app()->getClientScript()->registerScript('popup_message', $script, CClientScript::POS_READY);
        
    }
    
    
}
?>
