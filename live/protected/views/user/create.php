<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);
?>

<h1>Create User</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'model_countries' => $model_countries,
					     'model_zones' => $model_zones,
					    'countries' => $countries,
					    'zones' => $zones)); ?>