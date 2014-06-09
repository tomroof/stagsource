<?php
/* @var $this MessagesController */
/* @var $model Messages */

$this->breadcrumbs=array(
	'Messages'=>array('index'),
	$model->title,
);

?>

<h1>View Messages #<?php echo $model->id; ?></h1>
<div class="row buttons" style="float: right; width: auto;">
    <?php echo CHtml::link('Create message', array('/admin/messages/create'), array('class' => 'uibutton confirm')); ?>
    <?php echo CHtml::link('Manage messages', array('/admin/messages/admin'), array('class' => 'uibutton')); ?>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'content',
            array(               // related city displayed as a link
            'label'=>$model->getAttributeLabel('from_user_id'),
            'type'=>'raw',
            'value'=>$model->fromUser->email,
        ),
                 array(               // related city displayed as a link
            'label'=>$model->getAttributeLabel('to_user_id'),
            'type'=>'raw',
            'value'=>$model->toUser->email,
        ),
//		'from_user_id',
//		'to_user_id',
		'date',
            array(               // related city displayed as a link
            'label'=>$model->getAttributeLabel('read_status'),
            'type'=>'raw',
            'value'=>($model->read_status)?'read':"unread",
        ),
//		'read_status',
           
	),
)); ?>
