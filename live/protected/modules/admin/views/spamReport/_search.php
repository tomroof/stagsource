<?php
/* @var $this SpamReportController */
/* @var $model SpamReport */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'model_id'); ?>
		<?php echo $form->textField($model,'model_id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_reported'); ?>
		<?php echo $form->textField($model,'user_reported'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_datetime'); ?>
		<?php echo $form->textField($model,'create_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'causes'); ?>
		<?php echo $form->textField($model,'causes',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->