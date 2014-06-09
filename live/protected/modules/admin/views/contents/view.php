<?php
/* @var $this ContentsController */
/* @var $model Contents */

$this->breadcrumbs=array(
	'Contents'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Contents', 'url'=>array('index')),
	array('label'=>'Create Contents', 'url'=>array('create')),
	array('label'=>'Update Contents', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Contents', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Contents', 'url'=>array('admin')),
);
?>

<h1>View Contents #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'content_author',
		'created_at',
		'content_content',
		'content_title',
		'content_excerpt',
		'content_status',
		'content_comment_status',
		'content_password',
		'content_name',
		'content_modified',
		'content_parent',
		'content_menu_order',
		'content_type',
		'content_comment_count',
		'content_category_id',
	),
)); ?>
