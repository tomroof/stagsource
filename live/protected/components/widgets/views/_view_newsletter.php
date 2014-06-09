<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'newslatter',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>
    <div class="block-search-footer">
        <p class="label">
            <?php echo $form->LabelEx($model, 'email', array('for' => 'mes-foot')) ?>
<!--            <label for="mes-foot">Your Email Address</label>-->
            <?php echo $form->textField($model,'email', array('id' => 'mes-foot', 'autocomplete' => 'off')); ?>
        </p>
        <div class="sub-search-footer">
            <?php echo CHtml::submitButton(''); ?>
        </div>
        <?php //echo $form->error($model,'email'); ?>
    </div>
<?php $this->endWidget(); ?>