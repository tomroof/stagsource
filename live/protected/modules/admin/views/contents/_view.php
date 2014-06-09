<?php
/* @var $this ContentsController */
/* @var $data Contents */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_author')); ?>:</b>
	<?php echo CHtml::encode($data->content_author); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_content')); ?>:</b>
	<?php echo CHtml::encode($data->content_content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_title')); ?>:</b>
	<?php echo CHtml::encode($data->content_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_excerpt')); ?>:</b>
	<?php echo CHtml::encode($data->content_excerpt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_status')); ?>:</b>
	<?php echo CHtml::encode($data->content_status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('content_comment_status')); ?>:</b>
	<?php echo CHtml::encode($data->content_comment_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_password')); ?>:</b>
	<?php echo CHtml::encode($data->content_password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_name')); ?>:</b>
	<?php echo CHtml::encode($data->content_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_modified')); ?>:</b>
	<?php echo CHtml::encode($data->content_modified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_parent')); ?>:</b>
	<?php echo CHtml::encode($data->content_parent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_menu_order')); ?>:</b>
	<?php echo CHtml::encode($data->content_menu_order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_type')); ?>:</b>
	<?php echo CHtml::encode($data->content_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_comment_count')); ?>:</b>
	<?php echo CHtml::encode($data->content_comment_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_category_id')); ?>:</b>
	<?php echo CHtml::encode($data->content_category_id); ?>
	<br />

	*/ ?>

</div>