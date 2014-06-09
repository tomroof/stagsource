<?php
/* @var $this CelebritiesController */
/* @var $model Celebrities */

$this->breadcrumbs = array(
    'Celebrities' => array('index'),
    'Manage',
);

//$this->menu=array(
//	array('label'=>'List Celebrities', 'url'=>array('index')),
//	array('label'=>'Create Celebrities', 'url'=>array('create')),
//);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('celebrities-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Celebrities</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div>
<!-- search-form -->


<div class="row buttons" style="float: left; width:260px">
    <?php
    echo CHtml::link('Create Dancer', Yii::app()->createUrl('/admin/Celebrities/create'), array('class' => 'uibutton'));
    ?>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'celebrities-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'celebrity_id',
        'celebrity_name',
        'celebrity_description',
        'celebrity_img',
        'celebrity_permalink',
        'celebrity_parent',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
));
?>
