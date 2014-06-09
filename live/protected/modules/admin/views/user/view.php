<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->id,
);
?>
<?php if($model->pro_status == User::STATUS_USER_PRO_REQUEST) {?>
    <div style="margin-left: 473px">
        <h2>Please Confirm ore Decline user PRO request.</h2>
        <div style="margin-left: 184px;">
        <?php echo CHtml::link('Accept', Yii::app()->createUrl('/admin/user/adminProRequest', array('id' => $model->id, 'proStatus' => 'accept')), array('class' => 'uibutton'))?>
        <?php echo CHtml::link('Decline', Yii::app()->createUrl('/admin/user/adminProRequest', array('id' => $model->id, 'proStatus' =>  'decline')), array('class' => 'uibutton special' ))?>
        </div>
    </div>
<?php } ?>

<h1>View User #<?php echo $model->id; ?></h1>

<div class="row buttons" style="float: right; width:auto">
    <?php
    echo CHtml::link('Login', Yii::app()->createUrl('admin/user/loginasuser', array('id' => $model->id)), array('class' => 'uibutton normal'));
    echo CHtml::link('Update', array('update', 'id' => $model->id), array('class' => 'uibutton'));
    echo CHtml::link('Delete', '', array('submit' => array('delete', 'id' => $model->id), 'class' => 'uibutton special', 'confirm' => 'Are you sure you want to delete this item?'));
    ?>
</div>


<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'email',
        array(
            'name' => 'role_id',
//            'value' => User::getTextTypeUser($model->role_id),
        ),
        'first_name',
        'last_name',
        array(
            'name' => 'date_create',
            'value' => User::getTimeUSA($model->date_create)
        ),
    ),
));
?>
