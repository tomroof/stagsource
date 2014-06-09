<?php
/* @var $this SpamReportController */
/* @var $model SpamReport */

$this->breadcrumbs=array(
	'Spam Reports'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SpamReport', 'url'=>array('index')),
	array('label'=>'Create SpamReport', 'url'=>array('create')),
	array('label'=>'View SpamReport', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SpamReport', 'url'=>array('admin')),
);
?>

<h1>Update SpamReport <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>