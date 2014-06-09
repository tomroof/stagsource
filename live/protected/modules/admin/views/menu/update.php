<?php
$this->breadcrumbs=array(
	'Pages'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>Update Link <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form_update', array('model'=>$model)); ?>