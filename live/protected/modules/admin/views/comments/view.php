<?php

$this->breadcrumbs = array(
    'comment' => array('index'),
    $model->content,
);
?>

<h1>View comment #<?php echo $model->id; ?></h1>

<div class="row buttons" style="float: right; width: 345px; margin-right: -3px;">
    <?php echo CHtml::link('Create post', array('/admin/posts/create'), array('class' => 'uibutton confirm')); ?>
    <?php echo CHtml::link('Edit comment', array('/admin/comments/update/id/' . $model->id), array('class' => 'uibutton confirm')); ?>
    <?php echo CHtml::link('BACK TO THE POST', array('/admin/posts/view/id/'.$model->post_id), array('class' => 'uibutton')); ?>
</div>
<div class="row buttons" style="float: right; width: 104px; margin-right: -3px;">
</div>

<?php
$model_status = Options::model()->findByAttributes(array("type"=>"Status","code"=>2));

$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'content',
         array(
            'name' => 'status',
            'value' => $model_status->value,
        ),
        'created_at',
        'guest_name',
        'guest_email',
        'url',

           
    ),
));
?>