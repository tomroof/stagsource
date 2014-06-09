
<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1 class="grid_12">Update profile <?php echo $model->firs_name.' '.$model->last_name ; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'model_countries' => $model_countries,
					     'model_zones' => $model_zones,
					    'countries' => $countries,
					    'zones' => $zones)); ?>
