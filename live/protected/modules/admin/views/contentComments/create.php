<?php
/* @var $this ContentCommentsController */
/* @var $model ContentComments */

$this->breadcrumbs=array(
	'Content Comments'=>array('index'),
	'Create',
);

//$this->menu=array(
//	array('label'=>'List ContentComments', 'url'=>array('index')),
//	array('label'=>'Manage ContentComments', 'url'=>array('admin')),
//);
?>

<h1>Create ContentComments</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>