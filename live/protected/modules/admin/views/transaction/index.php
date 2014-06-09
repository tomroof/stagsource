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
<script type="text/javascript" >
    jQuery(document).ready(function($){
        $('.grid-view table.items tbody tr').click(function(){
            var href=$(this).find('.button-column .view').attr('href');
            window.location.href=href;
        })
    })
</script>
<h1>List of seller</h1>

<?php
 
 
$this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'user-grid',
        'dataProvider' => $model->search_seller(),
        'filter' => $model,
        'columns' => array(
                'id',
                'email',
                'postal_code',
//                array(
//                        'name' => 'role_id',
//                        'value' => 'Options::item("UserRole",$data->role_id)',
//                        'filter' => Options::items("UserRole"),
//                ),
                'firstname',
                'surname',
                'mobile',
                'landline',
                array(
                        'name' => 'date_create',
                        'value' => 'Functions::getTimeUSA($data->date_create)',
                ),
                /*
                  'password',
                  'sitenote',
                  'role',
                 */
                array(
                        'class' => 'CButtonColumn',
                    'template'=>'{view}'
                ),
        ),
));
 
?>
