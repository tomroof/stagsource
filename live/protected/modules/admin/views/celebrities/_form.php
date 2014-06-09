<?php
/* @var $this CelebritiesController */
/* @var $model Celebrities */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'celebrities-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'celebrity_name'); ?>
        <?php echo $form->textField($model, 'celebrity_name', array('size' => 60, 'maxlength' => 255)); ?>

    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'celebrity_description'); ?>
        <?php echo $form->textArea($model, 'celebrity_description', array('rows' => 6, 'cols' => 50)); ?>

    </div>

    <!--    <div class="row">
    <?php echo $form->labelEx($model, 'celebrity_img'); ?>
    <?php echo $form->textField($model, 'celebrity_img', array('size' => 60, 'maxlength' => 255)); ?>
    
        </div>-->


    <div class="oneThree">
        <div class="profileSetting block_callback" style="text-align: center;">
            <div class="avartar block_callback_img">
                <?php if ($model->celebrity_img != null) { ?>
                    <img src="<?php echo Yii::app()->createAbsoluteUrl($model->celebrity_img) ?>" width="180" alt="avatar">
                <?php } else { ?>
                    <img src="<?php echo Yii::app()->request->hostInfo . '/images/no_thumbnail.jpg'; ?>" width="180" alt="no_thumbnail">
                <?php } ?>
            </div>
            <?php echo CHtml::button('remove', array('class' => 'remove_thumbnail uibutton special')) ?>
            <div class="avartar">

                <?php echo $form->textField($model, 'celebrity_img', array('class' => 'fileDialogCustom ', 'title' => 'fileimport')) ?>

                <?php //echo $form->error($model, 'content_thumbnail');   ?>

                <p align="center"><?php echo $form->labelEx($model, 'celebrity_img'); ?></p>

            </div>
        </div>

    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'celebrity_permalink'); ?>
        <?php echo $form->textField($model, 'celebrity_permalink', array('size' => 60, 'maxlength' => 255)); ?>

    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'celebrity_parent'); ?>
        <?php echo $form->textField($model, 'celebrity_parent'); ?>

    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->