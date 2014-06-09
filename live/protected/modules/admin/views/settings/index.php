<?php if (Yii::app()->user->hasFlash('success')) { ?>
    <div class="alertMessage success SE" id="sflash">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php } ?>

<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs' => array(
        'Global Settings' => $this->renderPartial('global_settings', '', true),
        'Home Page' => $this->renderPartial('home_page_settings', '', true),
        'Notifications ' => $this->renderPartial('_site_notifications', '', true),
        'SEO Settings' => $this->renderPartial('_seo_settings', '', true),
//        'Premium Services' => $this->renderPartial('_premium_services', '', true),
        'Commmunity' => $this->renderPartial('_commmunity', '', true),
    ),
    'options' => array(
        'collapsible' => true,
    ),
));
?>