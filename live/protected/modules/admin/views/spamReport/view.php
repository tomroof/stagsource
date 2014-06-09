<?php
/* @var $this SpamReportController */
/* @var $model SpamReport */

$this->breadcrumbs=array(
	'Spam Reports'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SpamReport', 'url'=>array('index')),
	array('label'=>'Create SpamReport', 'url'=>array('create')),
	array('label'=>'Update SpamReport', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SpamReport', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SpamReport', 'url'=>array('admin')),
);
?>

<h1>View SpamReport #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'model',
		'model_id',
		'user_reported',
		'create_datetime',
		'causes',
	),
)); ?>
