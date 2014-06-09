<?php
/* @var $this CelebritiesController */
/* @var $model Celebrities */

$this->breadcrumbs=array(
	'Celebrities'=>array('index'),
	'Create',
);

//$this->menu=array(
//	array('label'=>'List Celebrities', 'url'=>array('index')),
//	array('label'=>'Manage Celebrities', 'url'=>array('admin')),
//);
?>

<h1>Create Celebrity</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>