<?php
/* @var $this ContentCommentsController */
/* @var $model ContentComments */

$this->breadcrumbs = array(
    'Content Comments' => array('index'),
    'Manage',
);

?>

<h1>Manage Content Comments</h1>
<div class="row buttons" style="float: right; width: auto;">
    <?php echo CHtml::link('Create Comment ', array('/admin/contentComments/create'), array('class' => 'uibutton confirm')); ?>
</div>
<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'content-comments-grid',
    'afterAjaxUpdate' => 'reinstallDropDown',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'content',
        array(
            'name' => 'status',
            'value' => 'ContentComments::getCommentStatus($data->id)',
            'filter' => CHtml::activeDropDownList($model, 'status', ContentComments::get_comment_status_list(), array('empty' => 'All')),
        ),
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
        'guest_name',
        'guest_email',
//        /*
//          'url',
//          'id',
//          'author_id',
//         */
        array(
            'name' => 'content_id',
            'value' => 'Contents::model()->findByPk($data->content_id)->content_title',
            'filter' => CHtml::activeDropDownList($model, 'content_id', CHtml::listData(Contents::model()->findAll(), 'id', 'content_title'), array(
                'empty' => 'All')),
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
