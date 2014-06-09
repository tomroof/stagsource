<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs = array(
    'Posts' => array('index'),
    $model->title,
);
?>

<h1>View Post #<?php echo $model->id; ?></h1>

<div class="row buttons" style="float: right; width: 320px; margin-right: -3px;">
    <?php echo CHtml::link('Create post', array('/admin/posts/create'), array('class' => 'uibutton confirm')); ?>
     <?php // echo CHtml::link('View post', Yii::app()->createAbsoluteUrl('/admin/posts/view', array('id' => $model->id)), array('class' => 'uibutton confirm')); ?>
    <?php echo CHtml::link('Update post', Yii::app()->createAbsoluteUrl('/admin/posts/update',array('id' => $model->id)), array('class' => 'uibutton normal')); ?>
    <?php echo CHtml::link('MANAGE POSTS', array('/admin/posts/admin'), array('class' => 'uibutton')); ?>
</div>
<!--<div class="row buttons" style="float: right; width: 104px; margin-right: -3px;">
</div>-->

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'title',
        'content',
        'tags',
//        'status',
        array(               // related city displayed as a link
            'label'=>$model->getAttributeLabel('status'),
            'type'=>'raw',
            'value'=> Posts::getTextStatusPost($model->status),
        ),
        array(               // related city displayed as a link
            'label'=>$model->getAttributeLabel('thumbnail'),
            'type'=>'raw',
            'value'=>$model->getThumbnail(60,60),
        ),
        'create_time',
        'update_time',
//        'author_id',
        array(               // related city displayed as a link
            'label'=>'Author id',
            'type'=>'raw',
            'value'=>$model->author_id,
        ),
        array(               // related city displayed as a link
            'label'=>'Author email',
            'type'=>'raw',
            'value'=>$model->user->email,
        ),
    ),
));
?>

<h1>Manage Comment</h1>
<!--<div class="row buttons" style="float: right; width: 104px; margin-right: -3px;">
<?php // echo CHtml::link('Create post', array('/admin/post/create'), array('class' => 'uibutton confirm')); ?>
</div>-->
<!--<div class="row buttons" style="float: right; width:260px">
    <a class="uibutton normal" href="/freelanceyii/index.php/admin/user/loginasuser/id/44">Login</a>
    <a class="uibutton" href="/freelanceyii/index.php/admin/user/update/id/44">Update</a>
    <a class="uibutton special" id="yt0">Delete</a>
    <a class="uibutton confirm" href="/freelanceyii/index.php/admin/user/Credit/id/44">Credit</a>
</div>-->

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button'));  ?>
<!--<div class="search-form" style="display:none">
<?php // $this->renderPartial('_search',array(	'model'=>$model,));  ?>
</div> search-form -->
<?php
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'post-grid',
    'dataProvider' => $model_comment->search($model_comment->post_id = $model->id),
    'filter' => $model_comment,
    'columns' => array(
        'id',
        'content',
        array(
            'name' => 'status',
            'value' => 'Posts::getTextStatusPost($data->status)',
            'filter' => CHtml::activeDropDownList($model_comment, 'status', Posts::getArrayStatusPosts(), array('empty' => 'All')),
        ),
        'guest_name',
        'guest_email',
        'url',
        array(
            'class' => 'CButtonColumn',
            'template' => '{view} {update} {delete}',
            'viewButtonUrl' => 'Yii::app()->createUrl("/admin/comments/view", array("id"=>$data->id))',
            'updateButtonUrl' => 'Yii::app()->createUrl("/admin/comments/update", array("id"=>$data->id))',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/admin/comments/delete", array("id"=>$data->id))'
        )
    ),
));
?>

