<?php
/* @var $this ContentCommentsController */
/* @var $model ContentComments */

$this->breadcrumbs=array(
	'Content Comments'=>array('index'),
	$model->id,
);

//$this->menu=array(
//	array('label'=>'List ContentComments', 'url'=>array('index')),
//	array('label'=>'Create ContentComments', 'url'=>array('create')),
//	array('label'=>'Update ContentComments', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete ContentComments', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage ContentComments', 'url'=>array('admin')),
//);
?>

<h1>View ContentComments #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'content',
		'status',
		'created_at',
		'guest_name',
		'guest_email',
		'url',
		'id',
		'author_id',
	),
)); ?>
