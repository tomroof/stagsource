<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Comment'=>array('index'),
	$model->content=>array('view','id'=>$model->id),
	'Update',
);

//$this->menu=array(
//	array('label'=>'List Post', 'url'=>array('index')),
//	array('label'=>'Create Post', 'url'=>array('create')),
//	array('label'=>'View Post', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage Post', 'url'=>array('admin')),
//);
?>

<h1>Update comment <?php echo $model->id; ?></h1>
<div class="row buttons" style="float: right; width: 145px; margin-right: -3px;">
<?php echo CHtml::link('BACK TO THE POST', array('/admin/posts/view/id/'.$model->post_id),array('class'=>'uibutton')); ?>
    </div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>