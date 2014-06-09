<section class="container_12 clearfix ui-sortable">
    <?php
    $this->breadcrumbs = array(
        'Pages' => array('index'),
        'Manage',
    );

    ?>
    <style type="text/css" >
        tbody td {
            padding-left: 8px !important;
        }
        thead input{
            margin: 0px !important;
        }
    </style>
    <h1>Manage Pages</h1>
<div class="row buttons" style="float: right; width: auto;">
    <?php echo CHtml::link('Create page', array('/admin/page/create'), array('class' => 'uibutton confirm')); ?>
    <?php echo CHtml::link('Create link', array('/admin/menu/admin'), array('class' => 'uibutton confirm')); ?>
</div>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $model->search(),
        'filter' => $model,
        'afterAjaxUpdate' => 'reinstallDropDown',
        'template' => '{items}',
        'columns' => array(
            array(
                'name' => 'title',
                'type' => 'raw',
                'value' => '$data->title'
            ),
            array(
                'name' => 'permalink',
                'type' => 'raw',
                'value' => '$data->permalink'
            ),
            array(
                'name' => 'status',
                'value' => 'Page::getTextStatusPage($data->status)',
                'filter' => CHtml::activeDropDownList($model, 'status', Page::getArrayStatusPages(), array('empty' => 'All')),
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{update}{delete}',
                'buttons' => array(
                    'update' => array(
                        'visible' => 'visibleTypePage($data->id)',
                    )
                )
            ),
        ),
    ));

    function visibleTypePage($id)
    {

        if (Page::model()->findByPk($id)->content != 'link')
            return TRUE;
        else
            return FALSE;
    }
    ?>
</section>
