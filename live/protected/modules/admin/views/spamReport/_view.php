<?php
/* @var $this SpamReportController */
/* @var $data SpamReport */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('model')); ?>:</b>
	<?php echo CHtml::encode($data->model); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('model_id')); ?>:</b>
	<?php echo CHtml::encode($data->model_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_reported')); ?>:</b>
	<?php echo CHtml::encode($data->user_reported); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->create_datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('causes')); ?>:</b>
	<?php echo CHtml::encode($data->causes); ?>
	<br />


</div>