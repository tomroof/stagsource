<?php
/* @var $this CelebritiesController */
/* @var $model Celebrities */

$this->breadcrumbs=array(
	'Celebrities'=>array('index'),
	$model->celebrity_id,
);

//$this->menu=array(
//	array('label'=>'List Celebrities', 'url'=>array('index')),
//	array('label'=>'Create Celebrities', 'url'=>array('create')),
//	array('label'=>'Update Celebrities', 'url'=>array('update', 'id'=>$model->celebrity_id)),
//	array('label'=>'Delete Celebrities', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->celebrity_id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Celebrities', 'url'=>array('admin')),
//);
?>

<h1>View Celebrities #<?php echo $model->celebrity_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'celebrity_id',
		'celebrity_name',
		'celebrity_description',
		'celebrity_img',
		'celebrity_permalink',
		'celebrity_parent',
	),
)); ?>
