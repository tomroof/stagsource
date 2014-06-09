<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
        'Users' => array('index'),
        'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

<?php 
 
$this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'user-grid',
        'afterAjaxUpdate' => 'reinstallDatePickerAndAllDropDown',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
                'id',
                'email',
//                array(
//                        'name' => 'role_id',
//                        'value' => 'User::model()->getTextTypeUser($data->role_id)',
//                ),
                'first_name',
                'last_name',
//                array(
//                        'name' => 'pro_status',
//                        'value' => 'User::getTestTypesUserPro($data->pro_status)',
//                        'filter' => CHtml::activeDropDownList($model, 'pro_status',User::getArrayTypesUserPro(), array(
//                    'empty' => 'All')),
//                ),
            array(
                'name' => 'date_create',
                'value' => '(strtotime($data->date_create)) ? date("m/d/Y H:i:s", strtotime($data->date_create)) : ""',
                'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'attribute' => 'date_create',
                    'model' => $model,
                    'options' => array(
//                    'changeYear' => true,
//                    'changeMonth' => true,
                        'hideIfNoPrevNext' => true,
                    ),
                    'htmlOptions' => array(
                        'id' => 'datepicker_for_due_date',
                        'value' => (strtotime($model->date_create)) ? date('m/d/Y', strtotime($model->date_create)) : '',
                    ),
                ), true)
            ),
                array(
                        'class' => 'CButtonColumn',
                    'template' => '{view} {update} {delete} {proRequest}',
                    'buttons'=>array(
                        'proRequest' => array(
                            'label'=>'Accept/Decline Pro Request', // text label of the button
                            'url'=>"CHtml::normalizeUrl(array('view', 'id'=>\$data->id))",
                            'imageUrl'=>'/images/warning-48.png',  // image URL of the button. If not set or false, a text link is used
                            'options' => array('class'=>'copy'), // HTML options for the button
                            'visible' => '$data->pro_status == User::STATUS_USER_PRO_REQUEST ',
                        ),
                    ),
                ),
        ),
));
 
?>
