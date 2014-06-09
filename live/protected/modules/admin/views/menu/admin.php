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

    <h1>Create Link</h1>

    <?php echo $this->renderPartial('_form_link', array('model' => $modelForm)); ?>

    <h1>Manage Links</h1>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $model->searchlinks(),
        'filter' => $model,
        'afterAjaxUpdate' => 'reinstallDropDown',
        'template' => '{items}',
        'columns' => array(
            array(
                'name' => 'title',
                'type' => 'raw',
                'value' => '$data->title'
            ),
            'url',
            array(
                'class' => 'CButtonColumn',
                'template' => '{update}{delete}',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("/admin/menu/update",array("id"=>$data->primaryKey))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("/admin/menu/delete",array("id"=>$data->primaryKey))',
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
