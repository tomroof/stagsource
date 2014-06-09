<?php
/* @var $this ContentsController */
/* @var $model Contents */
?>

<h1>Manage Contents</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<script>
    $(function () {
        $("#create_content_button")

            .button({
                text: true,
                //          icons: {
                //            primary: "ui-icon-triangle-1-s"
                //          }
            }
        )
            .click(function () {
                if ($(this).parent().next().css('display') == 'block') {
                    $(this).parent().next().hide();
                } else {
                    var menu = $(this).parent().next().show().position({
                        my: "left top",
                        at: "left bottom",
                        of: this
                    });

                    $(this).parent().next().find('a').click(function () {
                        menu.hide();
                        location.href = $(this).attr('href');

                    });
                }
                return false;
            })
            .parent()
            .buttonset()
            .next()
            .hide()
            .menu();
    });
</script>

<div>
    <div>

        <a id="create_content_button" class="uibutton" style="padding: 5px 12px 6px 12px; font-size: 12px;">Add Content</a>
    </div>
    <ul style="position: absolute;">
        <? foreach (Contents::get_type_list() as $key => $value) { ?>
            <li><?= CHtml::link($value, '/admin/contents/create/type/' . $key); ?></li>  
        <?php } ?>
    </ul>
</div>

<?php
$DataProvider = $model->searchNotCommunity();
//$DataProvider->criteria->addNotInCondition('content_type',array('community'));
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'contents-grid',
    'afterAjaxUpdate' => 'reinstallDatePickerAndAllDropDown',
    'dataProvider' => $DataProvider,
    'filter' => $model,
    'columns' => array(
        'id',
        'content_title',
        array(
            'name' => 'content_type',
            'value' => '$data->_type',
            'filter' => CHtml::activeDropDownList($model, 'content_type', Contents::get_type_list(), array(
                'empty' => 'All')),
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
        array(
            'name' => 'content_status',
            'value' => '$data->content_status',
            'filter' => CHtml::activeDropDownList($model, 'content_status', Contents::get_status_list(), array('empty' => 'All'))
        ),
        array(
            'name' => 'content_comment_status',
            'value' => '$data->content_comment_status',
            'filter' => CHtml::activeDropDownList($model, 'content_comment_status', Contents::get_comment_status_list(), array('empty' => 'All'))
        ),
        /*
          'content_password',
          'content_name',
          'content_modified',
          'content_parent',
          'content_menu_order',

          'content_comment_count',
          'content_category_id',
         */
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
));
?>
