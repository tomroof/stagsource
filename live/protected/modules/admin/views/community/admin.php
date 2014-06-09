<?php
/* @var $this CommunityController */
/* @var $model Contents */

$this->breadcrumbs = array(
    'Contents' => array('index'),
    'Manage',
);
?>
<h1>List of Community Posts</h1>

<div class="row buttons" style="float: left; width:260px">
    <?php
    echo CHtml::link('Create Community Post', Yii::app()->createUrl('/admin/community/create'), array('class' => 'uibutton'));
    ?>
</div>

<?php
if(!empty($model->author_name_1) || !empty($model->author_name_2)) {
    $model->content_author = $model->author_name_1 . ' ' . $model->author_name_2;
}
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'contents-grid',
    'afterAjaxUpdate' => 'reinstallDatePickerAndAllDropDown',
    'dataProvider' => $model->searchCommunity(),
    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'id',
            'name' => 'id',
            'filter' => false
        ),
        'content_title',
        array(
            'name' => 'content_author',
            'value' => 'User::getUserFullNameById($data->content_author)',
            'type' => 'raw',
//            'htmlOptions' => array(
//                    'value' => '$data->author_name_1 $data->author_name_2',
//                ),
        ),
//        'created_at',
        array(
            'name' => 'created_at',
            'value' => 'date("m/d/Y h:m:s", strtotime($data->created_at))',
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
        //'content_content',
//        'content_modified',
        'content_comment_count',
        /*
          'content_comment_status',
          'content_password',
          'content_name',
          'content_excerpt',
          'content_parent',
          'content_menu_order',
          'content_type',
          'content_category_id',
         */
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
));
?>
