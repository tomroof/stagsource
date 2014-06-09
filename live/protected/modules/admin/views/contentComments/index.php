<?php
/* @var $this ContentCommentsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Content Comments',
);

$this->menu=array(
	array('label'=>'Create ContentComments', 'url'=>array('create')),
	array('label'=>'Manage ContentComments', 'url'=>array('admin')),
);
?>

<h1>Content Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
