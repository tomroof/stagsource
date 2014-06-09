<?php
/* @var $this BlackwordsController */
/* @var $model Blackwords */

$this->breadcrumbs=array(
	'Blackwords'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Blackwords', 'url'=>array('index')),
	array('label'=>'Create Blackwords', 'url'=>array('create')),
	array('label'=>'Update Blackwords', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Blackwords', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Blackwords', 'url'=>array('admin')),
);
?>

<h1>View Blocked Words #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		array('name' => 'status', 'value' => $model->Status),
		array('name' => 'created_at', 'value' =>  (strtotime($model->created_at)) ? date('m/d/Y  H:i:s', strtotime($model->created_at)) : ''),
		array('name' => 'updated_at', 'value' =>  (strtotime($model->updated_at)) ? date('m/d/Y  H:i:s', strtotime($model->updated_at)) : ''),
	),
)); ?>
