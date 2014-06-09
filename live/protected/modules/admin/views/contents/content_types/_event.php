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
                        <label for="Contents_content_source">Buy Tickets</label>
<!--                        --><?php //echo $form->labelEx($model, 'content_source'); ?>
                        <?php echo $form->textField($model, 'content_source'); ?>

                    </div>
                    <div class="row">
                        <?php echo $form->labelEx($model, 'content_video_embed'); ?>
                        <?php echo $form->textArea($model, 'content_video_embed', array('rows' => 10, 'cols' => 80)); ?>
                    </div>
                    <div class="row slider-block">


                        <h1>Slider Images<span class="required"></span></h1>
                        <div class="slider">
                            <?php
                            $slider_images = $model->content_slider_images;

                            if ($slider_images != null) {
//                                echo "<pre>";
//                                var_dump($slider_images);
//                                echo "</pre>";
//                                die;
                                foreach ($slider_images as $i => $value) {
                                    ?>
                                    <div class="section slider_block">
                                        <label>Image</label>
                                        <div class="row-in">
                                            <img width="80" height="80" style="margin: 0 20px 10px 0;" src="<?php echo $value; ?>">
                                            <div class="box-fileupload">
                                                <input
                                                    class="fileDialogSettings"
                                                    type="text"
                                                    name="Contents[content_slider_images][<?php echo $i; ?>]"
                                                    value="<?php echo $value; ?>"><a style="position: relative; top: 4px; left: 32px;"
                                                    class="a_remove" href="javascript:void(0)"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icon/color_18/cross.png"></a>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <label>&nbsp;</label>
                        <a class="addrow_slider1 uibutton" style="margin-top: 15px;" href="javascript: void(0);">Add Image to Slider</a>


                        <script>
                            jQuery(document).ready(
                            function () {
                                $('.addrow_slider1').live('click', function (e) {
                                    var counter = $(".slider_block").length;
                                    var value = '<div class="section slider_block"><label>Image</label><div class="row-in" ><img width="80" height="80" style="margin: 0 20px 10px 0;" class="img_show" src=""><div class="box-fileupload"><input placeholder="Choose File" class ="fileDialogSettings" type="text" name="Contents[content_slider_images]['+counter+']"><a style="position: relative; top: 4px; left: 32px;" class="a_remove" href="javascript:void(0)"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icon/color_18/cross.png"></a></div></div></div>';
                                    $('.slider').append(value);
                                })

                                $('.a_remove').live('click', function () {
                                    $(this).parents(".section").remove();
                                    var section = $(".slider_block");
                                    section.each(function(i){
                                        $(this).find('input').attr("name",'Contents[content_slider_images]['+i+']');
                                    })
                                })
                            }
                        )
                        </script>

                    </div>


                    <div class="row">
                        <div class="block_callback">
                            <?php echo $form->labelEx($model, 'content_thumbnail'); ?>
                            <div class="row-in">
                                <div class="block_callback_img">
                                    <?php if ($model->content_thumbnail != null) { ?>
                                        <img
                                            src="<?php echo Yii::app()->createAbsoluteUrl($model->content_thumbnail) ?>"
                                            width="180" alt="avatar">
                                        <?php } else { ?>
                                        <img
                                            src="<?php echo Yii::app()->request->hostInfo . '/images/no_thumbnail.jpg'; ?>"
                                            width="180" alt="no_thumbnail">
                                        <?php } ?>
                                </div>
                                <?php echo CHtml::button('remove', array('class' => 'remove_thumbnail uibutton special top-space')) ?>
                                <div>
                                    <?php echo $form->textField($model, 'content_thumbnail', array('class' => 'fileDialogCustom ', 'title' => 'fileimport')) ?>
                                    <p align="center"></p>
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