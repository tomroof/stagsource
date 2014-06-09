<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Posts'=>array('index'),
	'Manage',
);

//$this->menu=array(
//	array('label'=>'List Post', 'url'=>array('index')),
//	array('label'=>'Create Post', 'url'=>array('create')),
//);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('post-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Posts</h1>
<div class="row buttons" style="float: right; width: 104px; margin-right: -3px;">
<?php echo CHtml::link('Create post', array('/admin/posts/create'),array('class'=>'uibutton confirm')); ?>
    </div>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<!--<div class="search-form" style="display:none">
<?php // $this->renderPartial('_search',array(	'model'=>$model,)); ?>
</div> search-form -->

<?php
$uploads_folder = Yii::app()->request->hostInfo;
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'post-grid',
    'afterAjaxUpdate' => 'reinstallDropDown',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'title',
        'permalink',
        'tags',
      array(
            'name' => 'status',
            'value' => 'Posts::getTextStatusPost($data->status)',
            'filter' => CHtml::activeDropDownList($model, 'status', Posts::getArrayStatusPosts(), array('empty' => 'All')),
        ),
        array(
            'name' => 'create_time',
            'value' => 'Functions::getTimeUSA($data->create_time)',
        ),
           array(
            'name' => '_useremail',
            'value' => '$data->user->email',
        ),
           array(
            'name' => '_category_id',
            'value' => 'Postcategoryrelation::model()->categorylist($data->id)',
                'filter' =>  CHtml::activeDropDownList($model, '_category_id', CHtml::listData(Categories::model()->findAll(), 'id', 'name'), array('empty' => 'All')),
        ),
               
        array(
            'name' => 'thumbnail',
            'value' => '$data->getThumbnail(60,60)',
            'filter' => FALSE,
            'type' => 'raw',
        ),

        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
