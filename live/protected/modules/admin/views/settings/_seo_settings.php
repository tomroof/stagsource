<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'validation',
    'enableAjaxValidation' => false,
));
?>
<h1>SEO Settings</h1>

<?php echo SettingsCHtml::settingsTextField('seo_title', array('class' => 'medium'), 'Title', 'SEO Title'); ?>

<?php echo SettingsCHtml::settingstextArea('seo_description', array('class' => 'medium', 'rows' => 6, 'cols' => 70), 'Description', 'SEO Description'); ?>

<?php echo SettingsCHtml::settingstextArea('seo_keywords', array('class' => 'medium', 'rows' => 6, 'cols' => 70), 'Keywords', 'SEO Keywords'); ?>

<?php echo SettingsCHtml::settingsTextField('seo_canonical_url', array('class' => 'medium'), 'Canonical Url', 'URL'); ?>

<p><?php echo CHtml::submitButton('Save', array('style' => 'margin-top: 8px;')); ?></p>
<?php $this->endWidget(); ?>