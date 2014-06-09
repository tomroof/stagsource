<?php
/* @var $this BlackwordsController */
/* @var $model Blackwords */

$this->breadcrumbs=array(
	'Blackwords'=>array('index'),
	'Manage',
);
?>

<h1>Manage Blocked Words</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'blockedwords-grid',
    'afterAjaxUpdate' => 'reinstallDatePickerAndAllDropDown',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
        array(
            'name' => 'status',
            'value' => '$data->Status',
            'filter' => CHtml::activeDropDownList($model, 'status', Blockedwords::getStatuslist(), array('empty' => 'All'))
        ),
        array(
            'name' => 'created_at',
            'value' => 'date("m/d/Y H:i:s", strtotime($data->created_at))',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'attribute' => 'created_at',
                'model' => $model,
                'options' => array(
//                    'changeYear' => true,
//                    'changeMonth' => true,
                    'hideIfNoPrevNext' => true,
                ),
                'htmlOptions' => array(
                    'id' => 'datepicker_for_due_date',
                    'value' => (strtotime($model->created_at)) ? date('m/d/Y', strtotime($model->created_at)) : '',
                ),
            ), true)
        ),
        array(
            'name' => 'updated_at',
            'value' => 'date("m/d/Y H:i:s", strtotime($data->updated_at))',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'attribute' => 'updated_at',
                'model' => $model,
                'options' => array(
//                    'changeYear' => true,
//                    'changeMonth' => true,
                    'hideIfNoPrevNext' => true,
                ),
                'htmlOptions' => array(
                    'id' => 'datepicker_updated_at',
                    'value' => (strtotime($model->updated_at)) ? date('m/d/Y', strtotime($model->updated_at)) : '',
                ),
            ), true)
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
