<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'contents-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <div class="widgets">
        <div class="twoOne">
            <div class="widget">
                <div class="header"><span><span class="ico gray window"></span>  Main Information   </span></div>
                <div class="content">
                    <div class="row">

                        <?php echo $form->errorSummary($model); ?>

                        <?php echo $form->labelEx($model, 'content_title'); ?>
                        <?php echo $form->textField($model, 'content_title'); ?>
                    </div>
                    <?php
                    $this->renderpartial('repeatable_content', array('model' => $model, 'form' => $form));
                    ?>


                    <div class="row">
                                <?php echo $form->labelEx($model, 'content_source'); ?>
                                <?php echo $form->textField($model, 'content_source'); ?>
                    </div>
                    <div class="row">
                        <div class="oneTwo">
                            <?php
                            $this->widget('webroot.protected.modules.poll.components.widgets.PollWidgetAdmin', array('model' => $model));
                            ?>
                        </div>
                    </div>


                    <div class="row">
                        <?php echo $form->labelEx($model, 'content_thumbnail'); ?>
                        <div class="row-in">
                            <div class="profileSetting block_callback">
                                <div class="block_callback_img">
                                    <?php if ($model->content_thumbnail != null) { ?>
                                        <img src="<?php echo Yii::app()->createAbsoluteUrl($model->content_thumbnail) ?>" width="180" alt="avatar">
                                    <?php } else { ?>
                                        <img src="<?php echo Yii::app()->request->hostInfo . '/images/no_thumbnail.jpg'; ?>" width="180" alt="no_thumbnail">
                                    <?php } ?>
                                </div>
                                <?php echo CHtml::button('remove', array('class' => 'remove_thumbnail uibutton special top-space')) ?>
                                <div>
                                    <?php echo $form->textField($model, 'content_thumbnail', array('class' => 'fileDialogCustom ', 'title' => 'fileimport')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $this->widget('application.modules.seopack.components.SeopackAdminWidget', array('model' => $model)); ?>
                    <div class="clear"></div>

                </div>
            </div>
        </div>
        <?php
        $this->renderpartial('_right_content_block', array('model' => $model, 'form' => $form));
        ?>
        <div class="clear"></div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.remove_thumbnail').live('click', function () {
            $(this).parents('.profileSetting').find('.fileDialogCustom').val('');
            $(this).parents('.profileSetting').find('.block_callback_img').html('');
            //                        console.log('remove_thumbnail');
        });
    });


</script>