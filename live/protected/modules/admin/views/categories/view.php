<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->name,
);

//$this->menu=array(
//	array('label'=>'List Categories', 'url'=>array('index')),
//	array('label'=>'Create Categories', 'url'=>array('create')),
//	array('label'=>'Update Categories', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Categories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Categories', 'url'=>array('admin')),
//);
//?>

<h1>View Categories #<?php echo $model->id; ?></h1>
<div class="row buttons" style="float: right; width: 370px; margin-right: -3px;">
    <?php echo CHtml::link('Create category', array('/admin/categories/create'), array('class' => 'uibutton confirm')); ?>
    <?php echo CHtml::link('Update category', array('/admin/categories/update?id='.$model->id), array('class' => 'uibutton normal')); ?>
    <?php echo CHtml::link('MANAGE category', array('/admin/categories/admin'), array('class' => 'uibutton')); ?>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
                'description',
                'category_img',
		'permalink',
            array(               // related city displayed as a link
            'label'=>$model->getAttributeLabel('category_img'),
            'type'=>'raw',
            'value'=>$model->getThumbnail(60,60,'category_img'),
        ),

//		'parent',
	),
)); ?>
