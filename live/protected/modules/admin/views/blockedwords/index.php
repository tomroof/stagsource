<?php
/* @var $this BlackwordsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Blackwords',
);

$this->menu=array(
	array('label'=>'Create Blackwords', 'url'=>array('create')),
	array('label'=>'Manage Blackwords', 'url'=>array('admin')),
);
?>

<h1>Blocked Words</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
