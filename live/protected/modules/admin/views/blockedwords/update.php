<?php
/* @var $this BlackwordsController */
/* @var $model Blackwords */

$this->breadcrumbs=array(
	'Blackwords'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);?>

<h1>Update Blocked Words <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>