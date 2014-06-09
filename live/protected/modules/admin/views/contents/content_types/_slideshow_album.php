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
                                <?php echo $form->labelEx($model, 'content_source'); ?>
                                <?php echo $form->textField($model, 'content_source'); ?>
                    </div>

                    <div class="row slider-block">


                        <h1>Slider Images<span class="required">*</span></h1>
                        <div class="slider">
                            <?php
                            $slider_images = $model->content_slider_images;
                            if ($slider_images != null) {
                                foreach ($slider_images as $i=>$value) {
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
                                        $(this).children('input').attr("name",'Contents[content_slider_images]['+i+']');
                                    })
                                })
                            }
                        )
                        </script>

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