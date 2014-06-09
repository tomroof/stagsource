<?php
/* @var $this CelebritiesController */
/* @var $data Celebrities */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('celebrity_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->celebrity_id), array('view', 'id'=>$data->celebrity_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('celebrity_name')); ?>:</b>
	<?php echo CHtml::encode($data->celebrity_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('celebrity_description')); ?>:</b>
	<?php echo CHtml::encode($data->celebrity_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('celebrity_img')); ?>:</b>
	<?php echo CHtml::encode($data->celebrity_img); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('celebrity_permalink')); ?>:</b>
	<?php echo CHtml::encode($data->celebrity_permalink); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('celebrity_parent')); ?>:</b>
	<?php echo CHtml::encode($data->celebrity_parent); ?>
	<br />


</div>