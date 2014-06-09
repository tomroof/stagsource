<?php
if(file_exists(Yii::getPathOfAlias('webroot') . $data)){
$img=$data;
}else{
$img=Contents::DEFAULT_IMAGE_BIG;
}?>
<li>
    <a href="<?= $permalink ?>" title="">
        <img src="<?= $img ?>"/>
    </a>
</li>


