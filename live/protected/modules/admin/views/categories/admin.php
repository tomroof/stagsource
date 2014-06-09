<?php
/* @var $this CategoriesController */
/* @var $model Categories */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Manage',
);

//$this->menu=array(
//	array('label'=>'List Categories', 'url'=>array('index')),
//	array('label'=>'Create Categories', 'url'=>array('create')),
//);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('categories-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Categories</h1>
<div class="row buttons" style="float: right; width: 125px; margin-right: -3px;">
<?php echo CHtml::link('Create category', array('/admin/categories/create'),array('class'=>'uibutton confirm')); ?>
    </div>
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>




<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'permalink',
            array(
            'name' => 'category_img',
            'value' => '$data->getThumbnail(60,60,"category_img")',
            'filter' => FALSE,
            'type' => 'raw',
        ),
//		'parent',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
