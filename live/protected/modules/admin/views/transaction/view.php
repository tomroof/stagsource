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

<h1>User transaction</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'transaction-grid',
    'dataProvider' => $model->search_for_admin($user_id),
    'filter' => $model,
    'columns' => array(
        'id',
        'status',
        'demand_ids',
        'summ_transaction',
        'date_transaction',
//                'postal_code',
//                array(
//                        'name' => 'role_id',
//                        'value' => 'Options::item("UserRole",$data->role_id)',
//                        'filter' => Options::items("UserRole"),
//                ),
//                'firstname',
//                'surname',
//                'mobile',
//                'landline',
//                array(
//                        'name' => 'date_create',
//                        'value' => 'Functions::getTimeUSA($data->date_create)',
//                ),
    /*
      'password',
      'sitenote',
      'role',
     */
//                array(
//                        'class' => 'CButtonColumn',
//                ),
    ),
));


