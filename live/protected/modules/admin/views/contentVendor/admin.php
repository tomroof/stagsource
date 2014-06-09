<?php
/* @var $this ContentsController */
/* @var $model Contents */
?>

<h1>LIST OF VENDOR POSTS</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<script>
    //    $(function() {
    //        $( "#create_content_button" )
    //        
    //        .button({
    //            text: true,
    //            //          icons: {
    //            //            primary: "ui-icon-triangle-1-s"
    //            //          }
    //        }
    //    )
    //        .click(function() {
    //            var menu = $( this ).parent().next().show().position({
    //                my: "left top",
    //                at: "left bottom",
    //                of: this
    //            });
    //            $( this).parent().next().find('a').click( function() {
    //                menu.hide();
    //                location.href = $(this).attr('href');
    //                
    //            });
    //            return false;
    //        })
    //        .parent()
    //        .buttonset()
    //        .next()
    //        .hide()
    //        .menu();
    //    });
</script>

<div>
    <div>

        <a id="create_content_button" href="<?php echo Yii::app()->createUrl('/admin/contentVendor/create/type/'.Contents::TYPE_VENDOR); ?>" class="uibutton" style="padding: 5px 12px 6px 12px; font-size: 12px;">Add Vendor</a>
    </div>

</div>

<?php
//$DataProvider = $model->searchNotCommunity();
//$DataProvider->criteria->addCondition('content_type!="community"');
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'contents-grid',
    'afterAjaxUpdate' => 'reinstallDatePickerAndAllDropDown',
    'dataProvider' => $model->searchCelebrities(),
    'filter' => $model,
    'columns' => array(
        'id',
        'content_title',
        //'content_type',
//        'created_at',
        array(
            'name' => 'created_at',
            'value' => 'Contents::model()->findByPk($data->id)->created_at',
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
//        'content_status',
        array(
            'name' => 'content_status',
            'value' => 'Contents::model()->findByPk($data->id)->content_status',
            'filter' => CHtml::activeDropDownList($model, 'content_status', Contents::get_status_list(), array('empty' => 'All'))
        ),
//        'content_comment_status',
        array(
            'name' => 'content_comment_status',
            'value' => 'Contents::model()->findByPk($data->id)->content_comment_status',
            'filter' => CHtml::activeDropDownList($model, 'content_comment_status', Contents::get_comment_status_list(), array('empty' => 'All'))
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
));
?>
