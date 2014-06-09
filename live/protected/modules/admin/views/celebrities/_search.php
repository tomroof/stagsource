<?php
/* @var $this CelebritiesController */
/* @var $model Celebrities */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'celebrity_id'); ?>
		<?php echo $form->textField($model,'celebrity_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'celebrity_name'); ?>
		<?php echo $form->textField($model,'celebrity_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'celebrity_description'); ?>
		<?php echo $form->textArea($model,'celebrity_description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'celebrity_img'); ?>
		<?php echo $form->textField($model,'celebrity_img',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'celebrity_permalink'); ?>
		<?php echo $form->textField($model,'celebrity_permalink',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'celebrity_parent'); ?>
		<?php echo $form->textField($model,'celebrity_parent'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->