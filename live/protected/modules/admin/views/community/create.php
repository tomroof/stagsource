<?php
/* @var $this CommunityController */
/* @var $model Contents */

$this->breadcrumbs=array(
	'Contents'=>array('index'),
	'Create',
);


?>

<h1>Create Community</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'array_category' => $array_category,)); ?>