<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'validation',
    'enableAjaxValidation' => false,
));
?>
    <h1>Commmunity</h1>

<?php echo SettingsCHtml::settingsTextField('commmunity_title', array('class' => 'medium'),'Title'); ?>

<?php echo SettingsCHtml::settingstextArea('commmunity_text', array('class' => 'medium', 'rows' => 6, 'cols' => 70),'DESCRIPTION'); ?>

    <div class="section">
        <label>Block 1 Image</label>
        <div class="block_callback_img">
            <?php if (Settings::getSettingValue('commmunity_banner') != null) { ?>
                <img class="img_show" width="80" height="80" style="margin: 0 20px 10px 0;" src="<?php echo Yii::app()->createAbsoluteUrl(Settings::getSettingValue('commmunity_banner')); ?>" />
            <?php } else { ?>
                <img class="img_show" width="80" height="80" style="margin: 0 20px 10px 0;" src="<?php echo Yii::app()->request->hostInfo . '/images/no_thumbnail.jpg'; ?>" />
            <?php } ?>
            <div class="box-fileupload">
                <input class="fileDialogSettings small fileupload" type="text" name="Settings[commmunity_banner]" value="<?php echo Settings::getSettingValue('commmunity_banner'); ?>" />
                <a style="position: relative; top: 4px; left: 32px;" class="a_remove_thumbnail special top-space" href="javascript:void(0)">
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icon/color_18/cross.png">
                </a>
            </div>
        </div>
    </div>

    <p><?php echo CHtml::submitButton('Save', array('style' => 'margin-top: 8px;')); ?></p>
<?php $this->endWidget(); ?>