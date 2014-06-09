<?php
/* @var $this SpamReportController */
/* @var $model SpamReport */

$this->breadcrumbs=array(
	'Spam Reports'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SpamReport', 'url'=>array('index')),
	array('label'=>'Manage SpamReport', 'url'=>array('admin')),
);
?>

<h1>Create SpamReport</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>