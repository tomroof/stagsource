<?php
$this->breadcrumbs=array(
	'Pages'=>array('index'),
	'Create',
);

?>

<h1>Create Link</h1>

<?php echo $this->renderPartial('_form_link', array('model'=>$model)); ?>