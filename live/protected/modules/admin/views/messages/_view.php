<?php
/* @var $this MessagesController */
/* @var $data Messages */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo CHtml::encode($data->content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('from_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->from_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('to_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->to_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('read_status')); ?>:</b>
	<?php echo CHtml::encode($data->read_status); ?>
	<br />


</div>