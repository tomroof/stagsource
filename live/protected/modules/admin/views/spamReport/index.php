<?php
/* @var $this SpamReportController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Spam Reports',
);

$this->menu=array(
	array('label'=>'Create SpamReport', 'url'=>array('create')),
	array('label'=>'Manage SpamReport', 'url'=>array('admin')),
);
?>

<h1>Spam Reports</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
