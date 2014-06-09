<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'maintenance-form',
    'enableAjaxValidation' => false,
        ));
?>
<h2>Site is <?php echo getTextStatusSite($meintenance_mod->code); ?></h2>
<div class="section">
    <label> Status <small>website status </small></label>
    <div>

        <?php echo CHtml::checkBox($meintenance_mod->value, $meintenance_mod->code, array('id' => 'online', 'class' => 'online')); ?>
        <p><?php echo CHtml::submitButton('Apply' , array('style'=>'margin-top: 8px;')); ?></p>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php

function getTextStatusSite($status)
{
    if ($status == 0)
        $out = 'Disabled';
    elseif ($status == 1)
        $out = 'Enable';

    return $out;
}
?>







