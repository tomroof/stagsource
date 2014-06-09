<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'newslatter',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<p class="label">
    <label for="hide4">Sign up for our e-newletters by entering your email here.</label>
    <?php echo $form->textField($model, 'email', array('id' => 'hide4', 'autocomplete' => 'off')); ?>
</p>
<?php echo CHtml::submitButton('Submit', array('class' => 'but-big but-green')); ?>
<?php $this->endWidget(); ?>