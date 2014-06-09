<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'validation',
    'enableAjaxValidation' => false,
        ));
?>
<h1>Slider Home Page</h1>
<div class="home_slider1">
    <?php
    $home_slider1_images = Settings::model()->getSliderUnserialize('slider_home1');
    if ($home_slider1_images != null) {
        $i = 0;
        foreach ($home_slider1_images as $value) {
            ?>

            <div class="section slider_home1_block">
                <label>Text 1</label>
                <div><textarea class="medium" name="slider_home1[<?php echo $i; ?>][slider-info_h1]"><?php echo $value['slider-info_h1']; ?></textarea></div>
                <label>Text 2</label>
                <div><textarea class="medium" name="slider_home1[<?php echo $i; ?>][slider-info_h1_2]"><?php echo $value['slider-info_h1_2']; ?></textarea></div>
<!--                <label>Button 1 Text</label>-->
<!--                <div><input class="medium" type="text" name="slider_home1[--><?php //echo $i; ?><!--][slider-info_button]" value="--><?php //echo $value['slider-info_button']; ?><!--"></div>-->
<!--                <label>Url 1</label>-->
<!--                <div><input class="medium" type="text" name="slider_home1[--><?php //echo $i; ?><!--][slider-info_url]" value="--><?php //echo $value['slider-info_url']; ?><!--"></div>-->
<!--                <label>Button 2 Text</label>-->
<!--                <div><input class="medium" type="text" name="slider_home1[--><?php //echo $i; ?><!--][slider-info_button_2]" value="--><?php //echo $value['slider-info_button_2']; ?><!--"></div>-->
<!--                <label>Url 2</label>-->
<!--                <div><input class="medium" type="text" name="slider_home1[--><?php //echo $i; ?><!--][slider-info_url_2]" value="--><?php //echo $value['slider-info_url_2']; ?><!--"></div>-->
                <label>Image</label>
                <div><img height="80" style="margin: 0 20px 10px 0;" src="<?php echo $value['slider-info_image']; ?>">
                    <div class="box-fileupload">
                        <input class="fileDialogSettings small fileupload" type="text" name="slider_home1[<?php echo $i; ?>][slider-info_image]" value="<?php echo $value['slider-info_image']; ?>">
                        <a style="position: relative; top: 4px; left: 32px;" class="a_remove" href="javascript:void(0)"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icon/color_18/cross.png"></a>
                    </div>
                </div>
            </div>

            <?php
            $i++;
        }
    }
    ?>
</div>
<label>&nbsp;</label>
<!--<a class="addrow_slider1 uibutton" style="margin-top: 15px;" href="javascript: void(0);">Add to Slider</a>-->

<p><?php echo CHtml::submitButton('Save', array('style' => 'margin-top: 8px;')); ?></p>
<?php $this->endWidget(); ?>

<script>
    jQuery(document).ready(
    function () {

        $('.addrow_slider1').live('click', function (e) {
            var counter = $(".slider_home1_block").length;
            console.log(counter);
            var value = '<div class="section slider_home1_block"><label>Text 1</label><div><textarea  class="medium" name="slider_home1['+counter+'][slider-info_h1]"></textarea></div><label>Text 2</label><div><textarea  class="medium" name="slider_home1['+counter+'][slider-info_h1_2]"></textarea></div><label>Button 1 Text</label><div><input class="medium" type="text" name="slider_home1['+counter+'][slider-info_button]"></div><label>Url 1</label><div><input class="medium" type="text" name="slider_home1['+counter+'][slider-info_url]"></div><label>Button 2 Text</label><div><input class="medium" type="text" name="slider_home1['+counter+'][slider-info_button_2]"></div><label>Url 2</label><div><input class="medium" type="text" name="slider_home1['+counter+'][slider-info_url_2]"></div><label>Image</label><div><img width="80" height="80" style="margin: 0 20px 10px 0;" class="img_show" src=""></div><div class="box-fileupload"><input placeholder="Choose File" class ="fileDialogSettings" type="text" name="slider_home1['+counter+'][slider-info_image]"><div class="filebtn" style="width: 190px; height: 30px; display: inline; position: absolute; margin-left: -168px; background-position: 100% 50%;"><input class="fileDialogSettings small fileupload" type="text" name="slider_home1['+counter+'][slider-info_image]" value="" style="position: absolute; height: 30px; width: 170px; margin-left: 5px; display: inline; cursor: pointer; opacity: 0;"></div><a style="position: relative; top: 4px; left: 32px;" class="a_remove" href="javascript:void(0)"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icon/color_18/cross.png"></a></div></div>';
            $('.home_slider1').append(value);
        })


        $('.a_remove').live('click', function () {
            $(this).parents(".section").remove();
            var section = $(".slider_home1_block");
            section.each(function(i){
                $(this).children('textarea').attr("name",'slider_home1['+i+'][slider-info_h1]');
                $(this).children('input').attr("name",'slider_home1['+i+'][slider-info_image]');
                $(this).children('textarea').attr("name",'slider_home1['+i+'][slider-info_p]');
                $(this).children('textarea').attr("name",'slider_home1['+i+'][slider-info_url]');
            })
        })
    }
)

</script>