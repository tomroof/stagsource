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

                        <div class="row">
                            <div class="oneTwo">
                                <div class="row">
                                    <?php echo CHtml::label('Facebook Post URL <span class="required">*</span>', 'content_source') ;?>
                                    <?php echo $form->textField($model, 'content_source'); ?>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (!empty($model->content_title)) { ?>
                        <h2>Preview get content</h2>
                        <?php
                            echo $form->labelEx($model, 'content_title');
                            echo $form->textField($model, 'content_title', array('disabled'=>"disabled"));
                        }
                        ?>
                    </div>
                    <div class="row">
                        <?php
                        if (!empty($model->content_content)) {
                            echo $form->labelEx($model, 'content_content');
                            echo $form->textArea($model, 'content_content', array('disabled'=>"disabled", 'rows' => 16, 'cols' => 80));
                        }
                        ?>
                        </div>
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
        });
    });


</script>