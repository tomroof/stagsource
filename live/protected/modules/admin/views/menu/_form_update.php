<div class="grid_12 no-box">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'page-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

    <div class="row">
            <?php echo $form->labelEx($model, 'title'); ?>
        <div style="margin-left: 197px; ">
<?php echo $form->textField($model, 'title', array('size' => 50, 'maxlength' => 10000)); ?>
<?php echo $form->error($model, 'title'); ?>
        </div>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model, 'url'); ?>
        <div style="margin-left: 197px; ">
<?php echo $form->textField($model, 'url', array('size' => 50, 'maxlength' => 255)); ?>
<?php echo $form->error($model, 'url'); ?>
        </div>
    </div>

<!--    <div class="row">
        <div class="section slider_home1_block">
            <div>
                <div><img width="80" height="80" style="margin: 0 20px 10px 0;" class="img_show" src="<?php echo $model->links_icon ?>"></div>
                <div class="box-fileupload">
                    <div class="box-fileupload">
                        <input class ="fileDialogSettings" type="text" name="Page[links_icon]" value="<?php echo $model->links_icon ?>">
                        <div class="filebtn" style="width: 190px; height: 30px; display: inline; position: absolute; margin-left: -168px; background-position: 100% 50%;">
                            <input class="fileDialogSettings small fileupload"  type="text" value="<?php echo $model->links_icon ?>" name="Page[links_icon]"  style="position: absolute; height: 30px; width: 170px; margin-left: 5px; display: inline; cursor: pointer; opacity: 0;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->


    <div class="actions">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
