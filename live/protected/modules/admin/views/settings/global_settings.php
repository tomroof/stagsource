<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'validation',
    'enableAjaxValidation' => false,
));
?>
<?php echo SettingsCHtml::settingsCheckBox('maintenance_mode', array('id' => 'online', 'class' => 'online'), 'Maintenance Mode'); ?>

<?php echo SettingsCHtml::settingsTextField('admin_email', '', 'Email', 'Admin email'); ?>

<?php echo SettingsCHtml::settingstextArea('site_logo', array('rows' => 6, 'cols' => 70), 'Logo', 'Main logo'); ?>

<?php echo SettingsCHtml::settingstextArea('main_page_text', array('rows' => 6, 'cols' => 70), 'Text', 'Main page'); ?>

<?php echo SettingsCHtml::settingstextArea('copyright', array('rows' => 6, 'cols' => 70), 'Copyright', 'Site'); ?>

<h1>Social Buttons</h1>
<?php echo SettingsCHtml::settingsTextField('facebook', '', 'Facebook', 'URL'); ?>
<?php echo SettingsCHtml::settingsTextField('twitter', '', 'Twitter', 'URL'); ?>
<?php echo SettingsCHtml::settingsTextField('instagram', '', 'Instagram', 'URL'); ?>
<?php echo SettingsCHtml::settingsTextField('googleplus', '', 'Goole Plus', 'URL'); ?>
<?php echo SettingsCHtml::settingsTextField('pinterest', '', 'Pinterest', 'URL'); ?>
<?php //echo SettingsCHtml::settingsTextField('tumblr', '', 'Tumblr', 'URL'); ?>
<?php //echo SettingsCHtml::settingsTextField('vimeo', '', 'Vimeo', 'URL'); ?>
<?php echo SettingsCHtml::settingsTextField('youtube', '', 'Youtube', 'URL'); ?>




<p><?php echo CHtml::submitButton('Save', array('style' => 'margin-top: 8px;')); ?></p>
<?php $this->endWidget(); ?>



