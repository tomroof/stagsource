<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
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
                        <?php echo $form->labelEx($model, 'content_question'); ?>
                        <?php echo $form->textArea($model, 'content_question'); ?>
                    </div>
                    <div class="row">
                        <?php echo $form->labelEx($model, 'content_answer'); ?>
                        <?php echo $form->textArea($model, 'content_answer'); ?>
                    </div>
                    <div class="row">
                        <?php echo $form->labelEx($model, 'content_source'); ?>
                        <?php echo $form->textField($model, 'content_source'); ?>

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