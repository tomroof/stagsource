<?php
/*$this->breadcrumbs=array(
	'Pages'=>array('index'),
	$model->title,
);*/

$this->title=$model->title;
?>

<?php $this->renderPartial('_view', array(
	'data'=>$model,
)); ?>
