<?php
/* @var $this CelebritiesController */
/* @var $model Celebrities */

$this->breadcrumbs=array(
	'Celebrities'=>array('index'),
	$model->celebrity_id=>array('view','id'=>$model->celebrity_id),
	'Update',
);

//$this->menu=array(
//	array('label'=>'List Celebrities', 'url'=>array('index')),
//	array('label'=>'Create Celebrities', 'url'=>array('create')),
//	array('label'=>'View Celebrities', 'url'=>array('view', 'id'=>$model->celebrity_id)),
//	array('label'=>'Manage Celebrities', 'url'=>array('admin')),
//);
?>

<h1>Update Celebrity <?php echo $model->celebrity_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>