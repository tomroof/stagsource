<?php
/* @var $this CelebritiesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Celebrities',
);

$this->menu=array(
	array('label'=>'Create Celebrities', 'url'=>array('create')),
	array('label'=>'Manage Celebrities', 'url'=>array('admin')),
);
?>

<h1>Celebrities</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
