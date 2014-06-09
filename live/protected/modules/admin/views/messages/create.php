<?php
/* @var $this MessagesController */
/* @var $model Messages */

$this->breadcrumbs=array(
	'Messages'=>array('index'),
	'Create',
);


?>

<h1>Create Message</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>