<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Posts'=>array('index'),
	'Create',
);

//$this->menu=array(
//	array('label'=>'List Post', 'url'=>array('index')),
//	array('label'=>'Manage Post', 'url'=>array('admin')),
//);
?>

<h1>Create Post</h1>
<div class="row buttons" style="float: right; width: 124px; margin-right: -3px;">
<?php echo CHtml::link('MANAGE POSTS', array('/admin/posts/admin'),array('class'=>'uibutton')); ?>
    </div>
<!--<div class="row buttons" style="float: right; width:260px">
    <a class="uibutton normal" href="/freelanceyii/index.php/admin/user/loginasuser/id/44">Login</a>
    <a class="uibutton" href="/freelanceyii/index.php/admin/user/update/id/44">Update</a>
    <a class="uibutton special" id="yt0">Delete</a>
    <a class="uibutton confirm" href="/freelanceyii/index.php/admin/user/Credit/id/44">Credit</a>
</div>-->

<?php echo $this->renderPartial('_form', array('model'=>$model,'model_user'=>$model_user)); ?>