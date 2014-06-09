<?php
/* @var $this SpamReportController */
/* @var $model SpamReport */

$this->breadcrumbs = array(
    'Spam Reports' => array('index'),
    'Manage',
);
?>

    <h1>Manage Spam Reports</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'spam-report-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'afterAjaxUpdate' => 'reinstallDropDown',
    'columns' => array(
        'id',
        'model',
//		'model_id',
        array(
            'header' => 'Spam Text',
            'value' => 'SpamReport::getSpamText($data->id)',
        ),
        array(
            'name' => 'user_reported_name',
            'header' => 'User Reported',
            'value' => '($data->user_rel->first_name)?$data->user_rel->first_name . " " .$data->user_rel->last_name:"" ',
            'type' => 'raw',
        ),
//        array(
//            'name' => 'create_datetime',
//            'value' => 'Functions::getTimeUSA($data->create_datetime)',
//        ),
        array(
            'name' => 'create_datetime',
            'value' => 'date("m/d/Y H:i:s", strtotime($data->create_datetime))',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'attribute' => 'create_datetime',
                'model' => $model,
                'options' => array(
//                    'changeYear' => true,
//                    'changeMonth' => true,
                    'hideIfNoPrevNext' => true,
                ),
                'htmlOptions' => array(
                    'id' => 'datepicker_for_due_date',
                    'value' => (strtotime($model->create_datetime)) ? date('m/d/Y', strtotime($model->create_datetime)) : '',
                ),
            ), true)
        ),
        array(
            'name' => 'causes',
            'type' => 'raw',
            'value' => 'SpamReport::getTextCauses($data->id)',
            'filter' => CHtml::activeDropDownList($model, 'causes', array(
                '1' => 'Explicit language',
                '2' => 'Attacks on groups or individual',
                '3' => 'Invades my privacy',
                '4' => 'Hateful speech or symbols',
                '5' => 'Spam or scam',
                '6' => 'Other'
            ), array('empty' => 'All')),
        ),
        array(
            'name' => 'status',
            'value' => 'SpamReport::getTextStatus($data->status)',
            'filter' => CHtml::activeDropDownList($model, 'status', SpamReport::getArrayStatus(), array('empty' => 'All')),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}',
            'buttons' => array
            (
                'update' => array(
                    'label' => 'Edit Comment',
                    'url' => '($data->model == "ContentComments")?array("/admin/contentComments/update", "id" => $data->model_id, "spId" => $data->id):""',
                    'options' => array(
                        'title' => 'Edit',
                        'class' => 'cgridviewButtons updateItem'
                    ),
                ),
            ),
        ),
    ),
)); ?>