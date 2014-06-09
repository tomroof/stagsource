<?php
/* @var $this SpamReportController */
/* @var $model SpamReport */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'spam-report-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>60,'maxlength'=>255)); ?>
	
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'model_id'); ?>
		<?php echo $form->textField($model,'model_id',array('size'=>11,'maxlength'=>11)); ?>
	
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_reported'); ?>
		<?php echo $form->textField($model,'user_reported'); ?>
	
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_datetime'); ?>
		<?php echo $form->textField($model,'create_datetime'); ?>
	
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'causes'); ?>
		<?php echo $form->textField($model,'causes',array('size'=>60,'maxlength'=>255)); ?>
	
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->