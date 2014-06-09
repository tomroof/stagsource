<section class="container_12 clearfix ui-sortable">
    <?php
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

    <h1>Manage Users </h1>


    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'user-grid',
        'dataProvider' => $model->search(),
        'itemsCssClass' => 'styled',
        'template' => '{items}',
        'htmlOptions' => array(
            'class' => 'box with-table'
        ),
        'filter' => $model,
        'columns' => array(
            'id',
            'email',
            //'passwd',
            'firs_name',
            'last_name',
//                'post',
            'phone',
            /*
              'date_create',
              'date_last_login', */
//     'type',
            array(
                'name' => 'type',
                'value' => 'User::model()->getTextTypeUser($data->type)',
                'filter' => array(1 => 'Admin', 3 => 'Advertiser', 2 => 'User'),
            ),
            array(
                'header' => 'Total Coupons',
                'value' => 'Coupon::model()->countTotalCouponUser($data->id)',
            ),
            //  'status',
            array(
                'class' => 'CButtonColumn',
                'template' => '{update} {delete} {login}',
                'buttons'=>array(
                'login'=>array(
                    'label'=>'Login',
                    'imageUrl'=>'/images/loginasuser.png',
                    'url'=>'Yii::app()->createUrl("users/user/loginasuser", array("id"=>$data->id))',
//                    'click'=>$js_preview,
                ),
            ),
            ),
        ),
    ));
    ?>
</section>