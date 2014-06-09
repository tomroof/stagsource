<div class="grid_12 no-box">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
        <div style="margin-left: 197px; ">
            <?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>10000)); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
        <div style="margin-left: 197px; ">
            <?php echo $form->textArea($model,'content',array('rows'=>8, 'cols'=>40,'maxlength'=>10000, 'class'=>'redactor')); ?>
            <?php echo $form->error($model,'content'); ?>
        </div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
        <div style="margin-left: 197px; ">
            <?php echo $form->dropDownList($model,'status', Page::getArrayStatusPages()); ?>
            <?php echo $form->error($model,'status'); ?>
        </div>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'sidebar_enable'); ?>
        <div style="margin-left: 197px; ">
            <?php echo $form->dropDownList($model,'sidebar_enable', array(Page::SIDEBAR_DISABLED => 'Disable', Page::SIDEBAR_ENABLED => 'Enabled')); ?>
            <?php echo $form->error($model,'sidebar_enable'); ?>
        </div>
	</div>

	<div class="actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->widget('ext.yiiext-imperavi-redactor-widget.ImperaviRedactorWidget',array(
    'selector'=>'.redactor',
    'options'=>array('convertDivs'=>false),
));?>