<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'validation',
    'enableAjaxValidation' => false,
        ));
?>

<?php echo SettingsCHtml::settingsTextField('premium_services_title', array('class' => 'medium'), 'Premium Services Title', 'Main title'); ?>

<?php echo SettingsCHtml::settingstextArea('premium_services_description', array('class' => 'medium', 'rows' => 6, 'cols' => 70), 'Premium Services Description', 'Main description'); ?>

<h1>Page Premium Services</h1>

<?php echo SettingsCHtml::settingsTextField('premium_services_block1_title', array('class' => 'medium'), 'Block 1 Title', 'Main title'); ?>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $('div.filebtn > input').css('opacity', '1');
    })
</script>

<?php echo SettingsCHtml::settingstextArea('premium_services_block1_description', array('class' => 'medium', 'rows' => 6, 'cols' => 70), 'Block 1 Description', 'Main description'); ?>

<div class="section">
    <label>Block 1 Image</label>
    <div class="block_callback_img">
        <?php if (Settings::getSettingValue('premium_services_block1_image') != null) { ?>
        <img class="img_show" width="80" height="80" style="margin: 0 20px 10px 0;" src="<?php echo Yii::app()->createAbsoluteUrl(Settings::getSettingValue('premium_services_block1_image')); ?>" />
        <?php } else { ?>
            <img class="img_show" width="80" height="80" style="margin: 0 20px 10px 0;" src="<?php echo Yii::app()->request->hostInfo . '/images/no_thumbnail.jpg'; ?>" />
        <?php } ?>
        <div class="box-fileupload">
            <input class="fileDialogSettings small fileupload" type="text" name="Settings[premium_services_block1_image]" value="<?php echo Settings::getSettingValue('premium_services_block1_image'); ?>" />
            <a style="position: relative; top: 4px; left: 32px;" class="a_remove_thumbnail special top-space" href="javascript:void(0)">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icon/color_18/cross.png">
            </a>
        </div>
    </div>
</div>



<?php echo SettingsCHtml::settingsTextField('premium_services_block2_title', array('class' => 'medium'), 'Block 2 Title', 'Main title'); ?>

<?php echo SettingsCHtml::settingstextArea('premium_services_block2_description', array('class' => 'medium', 'rows' => 6, 'cols' => 70), 'Block 2 Description', 'Main description'); ?>

<div class="section">
    <label>Block 2 Image</label>
    <div class="block_callback_img">
        <?php if (Settings::getSettingValue('premium_services_block2_image') != null) { ?>
            <img class="img_show" width="80" height="80" style="margin: 0 20px 10px 0;" src="<?php echo Yii::app()->createAbsoluteUrl(Settings::getSettingValue('premium_services_block2_image')); ?>" />
        <?php } else { ?>
            <img class="img_show" width="80" height="80" style="margin: 0 20px 10px 0;" src="<?php echo Yii::app()->request->hostInfo . '/images/no_thumbnail.jpg'; ?>" />
        <?php } ?>
        <div class="box-fileupload">
            <input class="fileDialogSettings small fileupload" type="text" name="Settings[premium_services_block2_image]" value="<?php echo Settings::getSettingValue('premium_services_block2_image'); ?>" />
            <a style="position: relative; top: 4px; left: 32px;" class="a_remove_thumbnail special top-space" href="javascript:void(0)">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icon/color_18/cross.png">
            </a>
        </div>
    </div>
</div>



<?php echo SettingsCHtml::settingsTextField('premium_services_block3_title', array('class' => 'medium'), 'Block 3 Title', 'Main title'); ?>

<?php echo SettingsCHtml::settingstextArea('premium_services_block3_description', array('class' => 'medium', 'rows' => 6, 'cols' => 70), 'Block 3 Description', 'Main description'); ?>

<div class="section">
    <label>Block 3 Image</label>
    <div class="block_callback_img">
        <?php if (Settings::getSettingValue('premium_services_block3_image') != null) { ?>
            <img class="img_show" width="80" height="80" style="margin: 0 20px 10px 0;" src="<?php echo Yii::app()->createAbsoluteUrl(Settings::getSettingValue('premium_services_block3_image')); ?>" />
        <?php } else { ?>
            <img class="img_show" width="80" height="80" style="margin: 0 20px 10px 0;" src="<?php echo Yii::app()->request->hostInfo . '/images/no_thumbnail.jpg'; ?>" />
        <?php } ?>
        <div class="box-fileupload">
            <input class="fileDialogSettings small fileupload" type="text" name="Settings[premium_services_block3_image]" value="<?php echo Settings::getSettingValue('premium_services_block3_image'); ?>" />
            <a style="position: relative; top: 4px; left: 32px;" class="a_remove_thumbnail special top-space" href="javascript:void(0)">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icon/color_18/cross.png">
            </a>
        </div>
    </div>
</div>

<p><?php echo CHtml::submitButton('Save', array('style' => 'margin-top: 8px;')); ?></p>
<?php $this->endWidget(); ?>