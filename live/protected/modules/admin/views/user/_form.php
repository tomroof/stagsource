<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('autocomplete' => 'off')
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    <?php // var_dump($model->attributes) ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 64)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>


    <div class="row">
        <?php
//        echo '<pre>';
//            var_dump(CHtml::listData(Options::model()->findAll(array('condition' => 'type = :UserRole', 'params' => array(':UserRole' => 'UserRole'))), 'code', 'value'));
//            echo '</pre>';
//            die;
        ?>
        <?php echo $form->labelEx($model, 'role_id'); ?>
        <?php echo $form->dropDownList($model, 'role_id', User::getArrayTypesUser()) ?>
        <?php echo $form->error($model, 'role_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'first_name'); ?>
        <?php echo $form->textField($model, 'first_name', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model, 'first_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'last_name'); ?>
        <?php echo $form->textField($model, 'last_name', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model, 'last_name'); ?>
    </div>



    <div class="row">

        <?php echo $form->labelEx($model, 'passwd'); ?>
        <?php echo $form->passwordField($model, 'passwd', array('size' => 60, 'maxlength' => 255, 'autocomplete' => 'off', 'value' => '')); ?>
        <?php echo $form->error($model, 'passwd'); ?>
    </div>

    <!--<div class="row">
        <?php /*echo $form->labelEx($model, 'pro_status'); */?>
        <?php /*echo $form->dropDownList($model, 'pro_status', User::getArrayTypesUserPro()) */?>
        <?php /*echo $form->error($model, 'pro_status'); */?>
    </div>-->

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->