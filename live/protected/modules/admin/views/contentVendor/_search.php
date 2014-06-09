<?php
/* @var $this ContentsController */
/* @var $model Contents */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_author'); ?>
		<?php echo $form->textField($model,'content_author',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_content'); ?>
		<?php echo $form->textArea($model,'content_content',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_title'); ?>
		<?php echo $form->textArea($model,'content_title',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_excerpt'); ?>
		<?php echo $form->textArea($model,'content_excerpt',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_status'); ?>
		<?php echo $form->textField($model,'content_status',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_comment_status'); ?>
		<?php echo $form->textField($model,'content_comment_status',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_name'); ?>
		<?php echo $form->textField($model,'content_name',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_modified'); ?>
		<?php echo $form->textField($model,'content_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_parent'); ?>
		<?php echo $form->textField($model,'content_parent',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_menu_order'); ?>
		<?php echo $form->textField($model,'content_menu_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_type'); ?>
		<?php echo $form->textField($model,'content_type',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_comment_count'); ?>
		<?php echo $form->textField($model,'content_comment_count',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_category_id'); ?>
		<?php echo $form->textField($model,'content_category_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->