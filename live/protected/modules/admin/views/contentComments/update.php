<?php
/* @var $this ContentCommentsController */
/* @var $model ContentComments */

$this->breadcrumbs=array(
	'Content Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

//$this->menu=array(
//	array('label'=>'List ContentComments', 'url'=>array('index')),
//	array('label'=>'Create ContentComments', 'url'=>array('create')),
//	array('label'=>'View ContentComments', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage ContentComments', 'url'=>array('admin')),
//);
?>

<h1>Update ContentComments <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>