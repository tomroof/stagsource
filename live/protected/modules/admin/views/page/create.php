<?php
$this->breadcrumbs=array(
	'Pages'=>array('index'),
	'Create',
);

?>

<h1>Create Page</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>